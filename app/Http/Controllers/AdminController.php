<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Bluetick;
use App\Models\Candidate;
use App\Models\ConnectionRequest;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function loginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Auto-seed admin if no admins exist
        if (Admin::count() === 0) {
            Admin::create([
                'name' => 'Rani Admin',
                'email' => 'admin@ranimatrimonial.com',
                'password' => Hash::make('admin123456'),
            ]);
        }

        if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $totalCandidates = Candidate::count();
        $pendingBlueTicks = Bluetick::with('candidate')->where('is_accept', 0)->latest()->get();
        $approvedBlueTicks = Bluetick::where('is_accept', 1)->count();
        $totalConnections = ConnectionRequest::count();
        $recentRequests = Bluetick::with('candidate')->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalCandidates',
            'pendingBlueTicks',
            'approvedBlueTicks',
            'totalConnections',
            'recentRequests'
        ));
    }

    public function bluetickRequests(Request $request)
    {
        $status = $request->query('status', 'all');
        $query = Bluetick::with('candidate')->latest();

        if ($status === 'pending') {
            $query->where('is_accept', 0);
        } elseif ($status === 'approved') {
            $query->where('is_accept', 1);
        } elseif ($status === 'rejected') {
            $query->where('is_accept', 2);
        }

        $requests = $query->paginate(15);

        return view('admin.blueticks', compact('requests', 'status'));
    }

    public function approveBluetick(Request $request, $id)
    {
        $bluetick = Bluetick::with('candidate')->findOrFail($id);
        $bluetick->update([
            'is_accept' => 1,
            'admin_notes' => $request->input('notes', 'Approved by Admin'),
        ]);

        $candidate = $bluetick->candidate;
        if ($candidate) {
            $candidate->update([
                'selfie_verified' => true,
            ]);

            // Create in-app notification for candidate
            NotificationService::createNotification(
                $candidate->id,
                'bluetick_status',
                'Blue Tick Verified! 🎉',
                'Congratulations! Your Aadhaar verification has been approved by Rani Matrimonial Admin. Your profile now carries the genuine Blue Tick Verified badge.',
                null,
                asset('logo.png'),
                route('my-profile'),
                'Verified'
            );
        }

        return response()->json([
            'success' => true,
            'message' => "Blue Tick verification approved for {$candidate->first_name} ({$candidate->getDisplayCodeAttribute()})!",
        ]);
    }

    public function rejectBluetick(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $bluetick = Bluetick::with('candidate')->findOrFail($id);
        $bluetick->update([
            'is_accept' => 2,
            'admin_notes' => $request->reason,
        ]);

        $candidate = $bluetick->candidate;
        if ($candidate) {
            $candidate->update([
                'selfie_verified' => false,
            ]);

            NotificationService::createNotification(
                $candidate->id,
                'bluetick_status',
                'Blue Tick Verification Update',
                "Your Blue Tick Verification was not approved: {$request->reason}. Please review and re-submit your valid documents.",
                null,
                asset('logo.png'),
                route('bluetick.verify'),
                'Action Required'
            );
        }

        return response()->json([
            'success' => true,
            'message' => "Blue Tick verification rejected for {$candidate->first_name}.",
        ]);
    }
}
