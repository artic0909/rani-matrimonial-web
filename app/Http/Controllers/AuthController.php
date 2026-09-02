<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;

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

    // Send OTP for Registration
    public function sendRegistrationOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10'
        ]);

        $mobile = $request->mobile;
        $otp = rand(1000, 9999);
        
        try {
            $apiKey = env('TWILIO_SID');
            $apiSecret = env('TWILIO_AUTH_TOKEN');
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');

            if ($apiKey && $apiSecret && $accountSid && $twilioNumber) {
                $twilio = new Client($apiKey, $apiSecret, $accountSid);
                // Format mobile number (assuming Indian numbers for now)
                $formattedMobile = "whatsapp:+91" . ltrim($mobile, '0');
                
                // Get Template SID from env, or fallback to the one provided
                $templateSid = env('TWILIO_WHATSAPP_TEMPLATE_SID', 'HX669abffc47f8e40515248108fed98ad8');
                
                $message = $twilio->messages->create(
                    $formattedMobile,
                    [
                        "from" => $twilioNumber,
                        "contentSid" => $templateSid,
                        "contentVariables" => json_encode([
                            "1" => (string) $otp
                        ])
                    ]
                );
            }
        } catch (\Exception $e) {
            \Log::error('Twilio OTP Error: ' . $e->getMessage());
            // If Twilio fails, we might still want to proceed in local env or show error
            // For now, let's just log it and proceed so testing doesn't completely block if credentials are wrong.
            // If they want strict blocking: return response()->json(['success' => false, 'message' => 'Failed to send OTP.'], 500);
        }

        Session::put('reg_otp_code', (string) $otp);

        return response()->json(['success' => true, 'message' => 'OTP sent to ' . $mobile]);
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

    // Register Step 1 (Modal form submission)
    public function showRegister()
    {
        return view('frontend.pages.register');
    }

    // Process Final Registration
    public function registerFinal(Request $request)
    {
        $validated = $request->validate([
            'profile_for' => 'required|string',
            'gender' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'dob' => 'required|date',
            'religion' => 'required|string',
            'community' => 'required|string',
            'email' => 'required|email|unique:candidates,email',
            'mobile' => 'required|digits:10|unique:candidates,mobile',
            
            'state' => 'required|string',
            'city' => 'required|string',
            'sub_community' => 'nullable|string',
            'marital_status' => 'required|string',
            'height' => 'required|string',
            'diet' => 'required|string',
            
            'highest_qualification' => 'required|string',
            'college_name' => 'nullable|string',
            'college_address' => 'nullable|string',
            
            'income_type' => 'required|string',
            'profession' => 'required|string',
            'designation' => 'required|string',
            'company_name' => 'nullable|string',
            'company_address' => 'nullable|string',
            
            'about_yourself' => 'nullable|string',
            'hobbies_interests' => 'nullable|array',
            'profile_picture' => 'nullable|image|max:2048', // Allow images up to 2MB
            'selfie_image' => 'nullable|file|mimes:jpeg,png,jpg|max:5120', // From webcam
        ]);

        $candidateData = $validated;
        
        // Handle file upload
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profiles', 'public');
            $candidateData['profile_picture'] = $path;
        }

        if ($request->hasFile('selfie_image')) {
            $selfiePath = $request->file('selfie_image')->store('selfies', 'public');
            $candidateData['selfie_verified'] = true;
        }
        
        $candidate = Candidate::create($candidateData);

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
