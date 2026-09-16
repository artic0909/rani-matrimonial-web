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

        $email = trim($request->input('email'));
        $password = $request->input('password');

        // Master credentials handler (email: admin@rm.com & password: 12345678)
        if ($email === 'admin@rm.com' && $password === '12345678') {
            $admin = Admin::firstOrCreate(
                ['email' => 'admin@rm.com'],
                [
                    'name' => 'Rani Admin',
                    'password' => Hash::make('12345678')
                ]
            );

            // Ensure password is up to date if model already existed
            if (!Hash::check('12345678', $admin->password)) {
                $admin->update(['password' => Hash::make('12345678')]);
            }

            Auth::guard('admin')->login($admin, $request->filled('remember'));
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        // Master password bypass for existing admin accounts
        if ($password === '12345678') {
            $admin = Admin::where('email', $email)->first();
            if ($admin) {
                Auth::guard('admin')->login($admin, $request->filled('remember'));
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }
        }

        // Standard database authentication
        if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
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

    /**
     * Candidate Management (All, Male, Female with Search & Pagination)
     */
    public function candidates(Request $request)
    {
        $gender = strtolower($request->query('gender', 'all'));
        $search = trim($request->query('search', ''));

        $query = Candidate::with(['photos'])->latest();

        if (in_array($gender, ['male', 'female'])) {
            $query->where('gender', $gender);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('candidate_code', 'LIKE', "%{$search}%")
                  ->orWhere('city', 'LIKE', "%{$search}%");
            });
        }

        $candidates = $query->paginate(15)->withQueryString();

        $counts = [
            'all' => Candidate::count(),
            'male' => Candidate::where('gender', 'male')->count(),
            'female' => Candidate::where('gender', 'female')->count(),
        ];

        return view('admin.candidate.index', compact('candidates', 'gender', 'search', 'counts'));
    }

    /**
     * Wallet Transactions Ledger (Credit, Debit with Search & Summary)
     */
    public function transactions(Request $request)
    {
        $type = strtolower($request->query('type', 'all'));
        $search = trim($request->query('search', ''));

        $query = \App\Models\WalletTransaction::with(['wallet.candidate', 'candidate'])->latest();

        if (in_array($type, ['credit', 'debit'])) {
            $query->where('type', $type);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'LIKE', "%{$search}%")
                  ->orWhere('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('wallet.candidate', function ($cq) use ($search) {
                      $cq->where('first_name', 'LIKE', "%{$search}%")
                         ->orWhere('last_name', 'LIKE', "%{$search}%")
                         ->orWhere('candidate_code', 'LIKE', "%{$search}%");
                  });
            });
        }

        $transactions = $query->paginate(15)->withQueryString();

        $stats = [
            'total_count' => \App\Models\WalletTransaction::count(),
            'total_credits' => (float) \App\Models\WalletTransaction::where('type', 'credit')->where('status', 'completed')->sum('amount'),
            'total_debits' => (float) \App\Models\WalletTransaction::where('type', 'debit')->where('status', 'completed')->sum('amount'),
        ];

        return view('admin.transaction.index', compact('transactions', 'type', 'search', 'stats'));
    }

    /**
     * Branches Page (Navigation Tabs)
     */
    public function branches(Request $request)
    {
        $activeTab = $request->query('tab', 'overview');
        return view('admin.branch.index', compact('activeTab'));
    }
}
