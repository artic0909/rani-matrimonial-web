<?php

namespace App\Http\Controllers;

use App\Mail\AdminNewHelpNotification;
use App\Mail\AdminNewTicketNotification;
use App\Mail\HelpInquiryUserConfirmation;
use App\Mail\TicketCreatedCandidateNotification;
use App\Models\Help;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class HelpSupportController extends Controller
{
    const ADMIN_EMAIL = 'sumatra.sales2424@gmail.com';

    /**
     * Display the Help & Contact Us Center (Public)
     */
    public function helpCenter(Request $request)
    {
        $candidate = Auth::guard('web')->user();
        return view('frontend.pages.help_center', compact('candidate'));
    }

    /**
     * Handle Public Help & Contact Us submission
     */
    public function submitHelp(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'country_code' => 'required|string|max:10',
            'mobile' => 'required|string|min:7|max:20',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10|max:4000',
        ], [
            'name.required' => 'Please provide your full name.',
            'email.required' => 'Please enter a valid email address.',
            'country_code.required' => 'Please select your country code.',
            'mobile.required' => 'Please enter your contact mobile number.',
            'subject.required' => 'Please specify the subject of your inquiry.',
            'message.required' => 'Please describe your query in detail (at least 10 characters).',
        ]);

        // Clean mobile number
        $validated['mobile'] = preg_replace('/[^0-9]/', '', $validated['mobile']);

        $help = Help::create([
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
            'country_code' => $validated['country_code'],
            'mobile' => $validated['mobile'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        // 1. Send confirmation email to candidate / user
        try {
            Mail::to($help->email)->send(new HelpInquiryUserConfirmation($help));
        } catch (\Exception $e) {
            Log::error("Failed to send user help confirmation email: " . $e->getMessage());
        }

        // 2. Send notification email to Admin (sumatra.sales2424@gmail.com)
        try {
            Mail::to(self::ADMIN_EMAIL)->send(new AdminNewHelpNotification($help));
        } catch (\Exception $e) {
            Log::error("Failed to send admin help notification email: " . $e->getMessage());
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your message has been submitted successfully. A confirmation email has been sent to you.',
            ]);
        }

        return back()->with('success', 'Thank you! Your message has been submitted successfully. A confirmation email has been sent to you.');
    }

    /**
     * Display Candidate Support & Tickets Dashboard (Auth only)
     */
    public function support(Request $request)
    {
        $candidate = Auth::guard('web')->user();
        if (!$candidate) {
            return redirect()->route('login')->with('error', 'Please log in to access Support & Help Desk.');
        }

        $tickets = Ticket::where('candidate_id', $candidate->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $counts = [
            'total' => Ticket::where('candidate_id', $candidate->id)->count(),
            'open' => Ticket::where('candidate_id', $candidate->id)->whereIn('status', ['open', 'in_progress'])->count(),
            'resolved' => Ticket::where('candidate_id', $candidate->id)->where('status', 'resolved')->count(),
        ];

        return view('frontend.pages.support', compact('candidate', 'tickets', 'counts'));
    }

    /**
     * Store new Support Ticket for candidate
     */
    public function storeTicket(Request $request)
    {
        $candidate = Auth::guard('web')->user();
        if (!$candidate) {
            return redirect()->route('login')->with('error', 'Please log in to submit a support ticket.');
        }

        $validated = $request->validate([
            'priority' => 'required|in:low,high,urgent',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10|max:5000',
            'screenshots' => 'nullable|array|max:5',
            'screenshots.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'priority.required' => 'Please select the ticket priority.',
            'subject.required' => 'Please provide a subject for this ticket.',
            'message.required' => 'Please explain the issue or question in detail.',
            'screenshots.max' => 'You can upload up to 5 screenshots.',
            'screenshots.*.image' => 'Uploaded files must be valid images (JPEG, PNG, WEBP).',
            'screenshots.*.max' => 'Each image must not exceed 5MB.',
        ]);

        $uploadedScreenshots = [];
        if ($request->hasFile('screenshots')) {
            foreach ($request->file('screenshots') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('tickets', 'public');
                    $uploadedScreenshots[] = $path;
                }
            }
        }

        $ticket = Ticket::create([
            'candidate_id' => $candidate->id,
            'priority' => $validated['priority'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'screenshots' => !empty($uploadedScreenshots) ? $uploadedScreenshots : null,
            'status' => 'open',
        ]);

        // 1. Send confirmation email to Candidate with Dynamic Ticket Code
        if (!empty($candidate->email)) {
            try {
                Mail::to($candidate->email)->send(new TicketCreatedCandidateNotification($ticket, $candidate));
            } catch (\Exception $e) {
                Log::error("Failed to send candidate ticket creation email: " . $e->getMessage());
            }
        }

        // 2. Send ticket alert to Admin (sumatra.sales2424@gmail.com)
        try {
            Mail::to(self::ADMIN_EMAIL)->send(new AdminNewTicketNotification($ticket, $candidate));
        } catch (\Exception $e) {
            Log::error("Failed to send admin ticket alert email: " . $e->getMessage());
        }

        return redirect()->route('support.index')->with('success', "Your support ticket [{$ticket->ticket_code}] has been raised successfully! Our support team will assist you shortly.");
    }
}
