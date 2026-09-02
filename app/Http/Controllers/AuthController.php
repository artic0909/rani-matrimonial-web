<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Login - Accept mobile and send/simulate OTP
    public function sendOtp(Request $request)
    {
        $request->validate(['mobile' => 'required|digits:10']);
        
        $candidate = Candidate::where('mobile', $request->mobile)->first();
        
        if (!$candidate) {
            return response()->json(['success' => false, 'message' => 'Mobile number not registered.'], 404);
        }

        // Simulate OTP (e.g., 1234)
        Session::put('otp_mobile', $request->mobile);
        Session::put('otp_code', '1234'); // Hardcoded for testing

        return response()->json(['success' => true, 'message' => 'OTP sent to ' . $request->mobile]);
    }

    // Verify OTP and Login
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:4']);

        $mobile = Session::get('otp_mobile');
        $code = Session::get('otp_code');

        if ($request->otp !== $code) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP'], 400);
        }

        $candidate = Candidate::where('mobile', $mobile)->first();
        Auth::login($candidate);
        
        Session::forget(['otp_mobile', 'otp_code']);

        return response()->json(['success' => true, 'redirect' => route('dashboard')]);
    }

    // Send OTP for Registration (Checking for uniqueness)
    public function sendRegistrationOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10|unique:candidates,mobile',
            'email' => 'required|email|unique:candidates,email'
        ]);

        // Simulate OTP
        Session::put('reg_otp_mobile', $request->mobile);
        Session::put('reg_otp_code', '1234');

        return response()->json(['success' => true, 'message' => 'OTP sent to ' . $request->mobile]);
    }

    // Verify OTP for Registration
    public function verifyRegistrationOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:4']);

        $code = Session::get('reg_otp_code');

        if ($request->otp !== $code) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP'], 400);
        }

        return response()->json(['success' => true]);
    }

    // Register Candidate
    public function register(Request $request)
    {
        // Simple validation, assuming front-end ensures all steps
        $request->validate([
            'profile_for' => 'required|string',
            'gender' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'dob' => 'required|date',
            'religion' => 'required|string',
            // Wait, where does mobile come from in registration?
            // The screenshots don't show mobile in registration steps.
            // But a mobile is required for login. Let's assume there's a mobile step or we generate a dummy one for now,
            // or the user adds mobile. I'll require mobile here.
            'mobile' => 'required|digits:10|unique:candidates,mobile'
        ]);

        $candidate = Candidate::create($request->all());

        // Auto login after registration
        Auth::login($candidate);

        return response()->json(['success' => true, 'redirect' => route('dashboard')]);
    }

    // Dummy dashboard
    public function dashboard()
    {
        return response("Candidate Dashboard (Protected Dummy Text)", 200);
    }
}
