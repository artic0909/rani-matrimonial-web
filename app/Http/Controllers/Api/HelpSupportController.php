<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AdminNewHelpNotification;
use App\Mail\AdminNewTicketNotification;
use App\Mail\HelpInquiryUserConfirmation;
use App\Mail\TicketCreatedCandidateNotification;
use App\Models\Help;
use App\Models\Story;
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
     * Return Help Center FAQs and contact information
     */
    public function helpCenter(Request $request)
    {
        $faqs = [
            [
                'question' => 'How does Rani Matrimonial ensure candidate verification?',
                'answer' => 'Every candidate undergoes phone OTP validation, live selfie authentication, and our optional Blue Tick government ID verification process before profiles receive the royal verified seal.'
            ],
            [
                'question' => 'What is the Royal Wallet and how do connection requests work?',
                'answer' => 'Your Royal Wallet allows seamless interaction with potential matches. Sending an interest locks ₹100, which is only deducted when both parties accept connection and initiate WhatsApp chat.'
            ],
            [
                'question' => 'How can I keep my photos private or viewable only on request?',
                'answer' => 'You can toggle photo privacy in My Profile settings. When enabled, other members must request access to view your full album.'
            ],
            [
                'question' => 'How do I report an inappropriate profile or fraudulent behavior?',
                'answer' => 'Click the Report button on any candidate profile or raise an urgent ticket right here in Support & Help Desk. Our moderation team reviews all reports within 2 hours.'
            ],
            [
                'question' => 'Can I delete or temporarily hide my profile?',
                'answer' => 'Yes, you can deactivate your account anytime from Account Settings. Your profile will be instantly hidden from all search results and matchmaking feeds.'
            ],
        ];

        $contactInfo = [
            'company_name' => 'Rani Matrimonial Pvt. Ltd.',
            'phone' => '+91 62922 37202',
            'support_email' => 'support@ranimatrimonial.com',
            'admin_email' => self::ADMIN_EMAIL,
            'whatsapp' => '+91 62922 37202',
            'address' => 'Salt Lake Sector V, Kolkata, West Bengal 700091, India',
            'working_hours' => 'Monday - Saturday: 10:00 AM - 7:00 PM IST',
        ];

        return response()->json([
            'success' => true,
            'contact_info' => $contactInfo,
            'faqs' => $faqs,
        ]);
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

        // 2. Send notification email to Admin
        try {
            Mail::to(self::ADMIN_EMAIL)->send(new AdminNewHelpNotification($help));
        } catch (\Exception $e) {
            Log::error("Failed to send admin help notification email: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your message has been submitted successfully. Our support team will reach out to you shortly.',
            'help_id' => $help->id,
        ]);
    }

    /**
     * Get candidate's tickets and summary counts
     */
    public function support(Request $request)
    {
        $candidate = $request->user() ?? Auth::user();
        if (!$candidate) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $tickets = Ticket::where('candidate_id', $candidate->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Transform screenshot URLs to absolute URLs
        $tickets->getCollection()->transform(function ($ticket) {
            if (!empty($ticket->screenshots) && is_array($ticket->screenshots)) {
                $ticket->screenshot_urls = array_map(function ($path) {
                    return str_starts_with($path, 'http') ? $path : asset('storage/' . $path);
                }, $ticket->screenshots);
            } else {
                $ticket->screenshot_urls = [];
            }
            return $ticket;
        });

        $counts = [
            'total' => Ticket::where('candidate_id', $candidate->id)->count(),
            'open' => Ticket::where('candidate_id', $candidate->id)->whereIn('status', ['open', 'in_progress'])->count(),
            'resolved' => Ticket::where('candidate_id', $candidate->id)->where('status', 'resolved')->count(),
        ];

        return response()->json([
            'success' => true,
            'counts' => $counts,
            'tickets' => $tickets,
        ]);
    }

    /**
     * Store new Support Ticket for candidate
     */
    public function storeTicket(Request $request)
    {
        $candidate = $request->user() ?? Auth::user();
        if (!$candidate) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
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

        // 1. Send confirmation email to Candidate
        if (!empty($candidate->email)) {
            try {
                Mail::to($candidate->email)->send(new TicketCreatedCandidateNotification($ticket, $candidate));
            } catch (\Exception $e) {
                Log::error("Failed to send candidate ticket creation email: " . $e->getMessage());
            }
        }

        // 2. Send ticket alert to Admin
        try {
            Mail::to(self::ADMIN_EMAIL)->send(new AdminNewTicketNotification($ticket, $candidate));
        } catch (\Exception $e) {
            Log::error("Failed to send admin ticket alert email: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => "Your support ticket [{$ticket->ticket_code}] has been raised successfully! Our support team will assist you shortly.",
            'ticket' => $ticket,
        ]);
    }

    /**
     * Get success stories for the community
     */
    public function stories(Request $request)
    {
        $stories = Story::where('is_active', true)
            ->orWhereNull('is_active')
            ->orderBy('id', 'desc')
            ->paginate(12);

        $stories->getCollection()->transform(function ($story) {
            $photo = asset('img/dummy-story.jpg');
            if (!empty($story->photo)) {
                $photo = str_starts_with($story->photo, 'http') ? $story->photo : asset('storage/' . $story->photo);
            }
            $story->photo_url = $photo;
            return $story;
        });

        return response()->json([
            'success' => true,
            'stories' => $stories,
        ]);
    }
}
