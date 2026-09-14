<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\ConnectionRequest;
use App\Models\Notification;
use App\Models\WhatsAppChatRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class NotificationService
{
    /**
     * Create a notification record in database
     */
    public static function createNotification(
        int $candidateId,
        string $type,
        string $title,
        string $message,
        ?int $senderId = null,
        ?string $photo = null,
        ?string $actionUrl = null,
        ?string $badge = null
    ): Notification {
        return Notification::create([
            'candidate_id' => $candidateId,
            'sender_id' => $senderId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'photo' => $photo,
            'action_url' => $actionUrl,
            'badge' => $badge,
            'is_read' => false,
            'is_dismissed' => false,
        ]);
    }

    /**
     * Automatically synchronize existing candidate events into notifications table
     */
    public static function syncCandidateNotifications(Candidate $candidate): void
    {
        // 1. Received connection requests (pending)
        $receivedPending = ConnectionRequest::where('receiver_id', $candidate->id)
            ->where('status', 'pending')
            ->get();

        foreach ($receivedPending as $cr) {
            $exists = Notification::where('candidate_id', $candidate->id)
                ->where('sender_id', $cr->sender_id)
                ->where('type', 'connection_request')
                ->exists();

            if (!$exists) {
                $sender = Candidate::find($cr->sender_id);
                if ($sender) {
                    $sName = trim(($sender->first_name ?? 'Candidate') . ' ' . ($sender->last_name ?? ''));
                    $sPhoto = $sender->profile_picture
                        ? (str_starts_with($sender->profile_picture, 'http') ? $sender->profile_picture : (str_starts_with($sender->profile_picture, 'img/') ? asset($sender->profile_picture) : asset('storage/' . $sender->profile_picture)))
                        : 'https://ui-avatars.com/api/?name=' . urlencode($sName) . '&background=fdf2f8&color=db2777';

                    Notification::create([
                        'candidate_id' => $candidate->id,
                        'sender_id' => $sender->id,
                        'type' => 'connection_request',
                        'title' => $sName,
                        'message' => 'sent you a connection request.',
                        'photo' => $sPhoto,
                        'action_url' => route('inbox', ['tab' => 'received']),
                        'badge' => 'Interest',
                        'is_read' => false,
                        'is_dismissed' => false,
                        'created_at' => $cr->created_at ?? now(),
                        'updated_at' => $cr->updated_at ?? now(),
                    ]);
                }
            }
        }

        // 2. Accepted connection requests
        $acceptedConns = ConnectionRequest::where('status', 'accepted')
            ->where(function ($q) use ($candidate) {
                $q->where('sender_id', $candidate->id)
                    ->orWhere('receiver_id', $candidate->id);
            })
            ->get();

        foreach ($acceptedConns as $cr) {
            $otherId = ($cr->sender_id === $candidate->id) ? $cr->receiver_id : $cr->sender_id;
            $exists = Notification::where('candidate_id', $candidate->id)
                ->where('sender_id', $otherId)
                ->where('type', 'connection_accepted')
                ->exists();

            if (!$exists) {
                $other = Candidate::find($otherId);
                if ($other) {
                    $oName = trim(($other->first_name ?? 'Candidate') . ' ' . ($other->last_name ?? ''));
                    $oPhoto = $other->profile_picture
                        ? (str_starts_with($other->profile_picture, 'http') ? $other->profile_picture : (str_starts_with($other->profile_picture, 'img/') ? asset($other->profile_picture) : asset('storage/' . $other->profile_picture)))
                        : 'https://ui-avatars.com/api/?name=' . urlencode($oName) . '&background=eff6ff&color=1d4ed8';

                    Notification::create([
                        'candidate_id' => $candidate->id,
                        'sender_id' => $other->id,
                        'type' => 'connection_accepted',
                        'title' => $oName,
                        'message' => ($cr->sender_id === $candidate->id) ? 'accepted your connection request!' : 'is now connected with you.',
                        'photo' => $oPhoto,
                        'action_url' => route('matches', ['tab' => 'accepted']),
                        'badge' => 'Connected',
                        'is_read' => false,
                        'is_dismissed' => false,
                        'created_at' => $cr->updated_at ?? ($cr->created_at ?? now()),
                        'updated_at' => $cr->updated_at ?? now(),
                    ]);
                }
            }
        }

        // 3. WhatsApp chat requests
        $wpRequests = WhatsAppChatRequest::where('receiver_id', $candidate->id)
            ->where('status', 'pending')
            ->get();

        foreach ($wpRequests as $wpr) {
            $exists = Notification::where('candidate_id', $candidate->id)
                ->where('sender_id', $wpr->sender_id)
                ->where('type', 'whatsapp_request')
                ->exists();

            if (!$exists) {
                $sender = Candidate::find($wpr->sender_id);
                if ($sender) {
                    $sName = trim(($sender->first_name ?? 'Candidate') . ' ' . ($sender->last_name ?? ''));
                    $sPhoto = $sender->profile_picture
                        ? (str_starts_with($sender->profile_picture, 'http') ? $sender->profile_picture : (str_starts_with($sender->profile_picture, 'img/') ? asset($sender->profile_picture) : asset('storage/' . $sender->profile_picture)))
                        : 'https://ui-avatars.com/api/?name=' . urlencode($sName) . '&background=ecfdf5&color=059669';

                    Notification::create([
                        'candidate_id' => $candidate->id,
                        'sender_id' => $sender->id,
                        'type' => 'whatsapp_request',
                        'title' => $sName,
                        'message' => 'requested a direct WhatsApp chat with you.',
                        'photo' => $sPhoto,
                        'action_url' => route('inbox'),
                        'badge' => 'WhatsApp',
                        'is_read' => false,
                        'is_dismissed' => false,
                        'created_at' => $wpr->created_at ?? now(),
                        'updated_at' => $wpr->updated_at ?? now(),
                    ]);
                }
            }
        }
    }

    /**
     * Dispatch WhatsApp Notification when a Blue Tick verification form is submitted
     * Meta Template format:
     * 🔔 New Blue Tick Verification Request Rani Matrimonial theke ekjon user Blue Tick Verification-er jonno form submit korechen.
     * Name: {{1}} Profile ID: {{3}} Submitted on: {{4}} Please review and process the request.
     */
    public static function dispatchBlueTickSubmittedWhatsApp(Candidate $candidate): void
    {
        $adminMobile = env('ADMIN_WHATSAPP_NUMBER') ?: (config('services.twilio.admin_whatsapp') ?: '6292237205');

        try {
            $apiKey = config('services.twilio.sid') ?: env('TWILIO_SID');
            $apiSecret = config('services.twilio.auth_token') ?: env('TWILIO_AUTH_TOKEN');
            $accountSid = config('services.twilio.account_sid') ?: env('TWILIO_ACCOUNT_SID');
            $twilioNumber = config('services.twilio.whatsapp_number') ?: env('TWILIO_WHATSAPP_NUMBER');

            if ($apiKey && $apiSecret && $accountSid && $twilioNumber && !empty($adminMobile)) {
                $twilio = new Client($apiKey, $apiSecret, $accountSid);

                $cleanMobile = preg_replace('/[^0-9]/', '', $adminMobile);
                if (strlen($cleanMobile) === 10) {
                    $formattedMobile = 'whatsapp:+91' . $cleanMobile;
                } elseif (strlen($cleanMobile) === 12 && str_starts_with($cleanMobile, '91')) {
                    $formattedMobile = 'whatsapp:+' . $cleanMobile;
                } else {
                    $formattedMobile = 'whatsapp:+91' . ltrim($cleanMobile, '0');
                }

                // Template SID for Blue Tick verification (hardcoded)
                $templateSid = 'HX50f78c16ddaa58da573eb2f500f18505';

                $candidateName = trim(($candidate->first_name ?? '') . ' ' . ($candidate->last_name ?? ''));
                $profileId = $candidate->getDisplayCodeAttribute();
                $submittedDate = Carbon::now()->format('d M Y');

                $contentVariables = json_encode([
                    '1' => $candidateName,
                    '3' => $profileId,
                    '4' => strtoupper($submittedDate),
                ]);

                $twilio->messages->create(
                    $formattedMobile,
                    [
                        'from' => $twilioNumber,
                        'contentSid' => $templateSid,
                        'contentVariables' => $contentVariables,
                    ]
                );

                Log::info("WhatsApp Blue Tick submitted notification sent for {$profileId} ({$candidateName}) to {$formattedMobile}");
            }
        } catch (\Exception $e) {
            Log::error('Twilio Blue Tick WhatsApp Error: ' . $e->getMessage());
        }
    }
}
