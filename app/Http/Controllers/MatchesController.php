<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\ConnectionRequest;
use App\Models\Shortlisted;
use App\Models\WhatsAppChatRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class MatchesController extends Controller
{
    /**
     * Display Matches page with dynamically filtered sub-tabs
     */
    public function index(Request $request)
    {
        /** @var Candidate $candidate */
        $candidate = Auth::user();
        $tab = $request->query('tab', 'todays');
        if (! in_array($tab, ['todays', 'shortlisted', 'my_matches', 'accepted'])) {
            $tab = 'todays';
        }

        // Robust opposite gender detection
        $userGender = strtolower(trim($candidate->gender ?? ''));
        $targetGender = ($userGender === 'male' || $userGender === 'man') ? 'Female' : 'Male';

        // Load shortlisted profile IDs from database
        $rawShortlisted = Shortlisted::where('candidate_id', $candidate->id)
            ->pluck('profile_id')
            ->toArray();
        $shortlistedIds = [];
        foreach ($rawShortlisted as $sid) {
            $shortlistedIds[] = (string) $sid;
            $sc = Candidate::where('profile_id', $sid)->orWhere('candidate_code', $sid)->orWhere('id', is_numeric($sid) ? $sid : 0)->first();
            if ($sc) {
                $shortlistedIds[] = $sc->getDisplayCodeAttribute();
                $shortlistedIds[] = (string) $sc->id;
            }
        }
        $shortlistedIds = array_values(array_unique($shortlistedIds));

        // Load sent connection requests (pending only)
        $sentRequests = ConnectionRequest::where('sender_id', $candidate->id)->pending()->get();
        $sentInterestIds = [];
        foreach ($sentRequests as $sr) {
            $rec = Candidate::find($sr->receiver_id);
            if ($rec) {
                $sentInterestIds[] = $rec->getDisplayCodeAttribute();
                $sentInterestIds[] = (string) $rec->id;
            }
        }
        $sentInterestIds = array_values(array_unique($sentInterestIds));

        // Load received connection requests (pending only)
        $receivedRequests = ConnectionRequest::where('receiver_id', $candidate->id)->pending()->get();
        $receivedInterestIds = [];
        foreach ($receivedRequests as $rr) {
            $sender = Candidate::find($rr->sender_id);
            if ($sender) {
                $receivedInterestIds[] = $sender->getDisplayCodeAttribute();
                $receivedInterestIds[] = (string) $sender->id;
            }
        }
        $receivedInterestIds = array_values(array_unique($receivedInterestIds));

        // Load accepted connection requests (where candidate is either sender or receiver)
        $acceptedConnections = ConnectionRequest::accepted()
            ->where(function ($q) use ($candidate) {
                $q->where('sender_id', $candidate->id)
                    ->orWhere('receiver_id', $candidate->id);
            })
            ->get();

        $acceptedCandidateIds = [];
        $acceptedProfileCodes = [];
        foreach ($acceptedConnections as $conn) {
            $otherId = ($conn->sender_id === $candidate->id) ? $conn->receiver_id : $conn->sender_id;
            $acceptedCandidateIds[] = $otherId;
            $other = Candidate::find($otherId);
            if ($other) {
                $acceptedProfileCodes[] = $other->getDisplayCodeAttribute();
                $acceptedProfileCodes[] = (string) $other->id;
            }
        }
        $acceptedProfileCodes = array_values(array_unique($acceptedProfileCodes));

        // Full pool for dynamic counts
        $allMatches = $this->getMatchesData($candidate, $targetGender, 'my_matches', $shortlistedIds, $sentInterestIds, $receivedInterestIds, $acceptedCandidateIds);
        $todaysMatches = $this->getMatchesData($candidate, $targetGender, 'todays', $shortlistedIds, $sentInterestIds, $receivedInterestIds, $acceptedCandidateIds);
        $acceptedMatches = $this->getMatchesData($candidate, $targetGender, 'accepted', $shortlistedIds, $sentInterestIds, $receivedInterestIds, $acceptedCandidateIds);
        $shortlistedMatches = $this->getMatchesData($candidate, $targetGender, 'shortlisted', $shortlistedIds, $sentInterestIds, $receivedInterestIds, $acceptedCandidateIds);

        // Filtered matches for the active tab
        $matches = match ($tab) {
            'my_matches' => $allMatches,
            'todays' => $todaysMatches,
            'accepted' => $acceptedMatches,
            default => $shortlistedMatches,
        };

        // Counts for tabs
        $counts = [
            'todays' => count($todaysMatches),
            'shortlisted' => count($shortlistedMatches),
            'my_matches' => count($allMatches),
            'accepted' => count($acceptedMatches),
        ];

        return view('frontend.pages.matches', compact(
            'candidate',
            'tab',
            'matches',
            'counts',
            'shortlistedIds',
            'sentInterestIds',
            'receivedInterestIds',
            'acceptedProfileCodes'
        ));
    }

    /**
     * Generate dynamic, freshly randomized, clean url-safe profile token
     */
    public static function generateProfileToken($candidate): string
    {
        $code = $candidate instanceof Candidate ? $candidate->getDisplayCodeAttribute() : (string) $candidate;
        $nonce = substr(md5(uniqid(mt_rand(), true)), 0, 10);
        
        return $code . '-' . $nonce;
    }

    /**
     * Decode dynamic profile token back to Candidate model
     */
    public static function resolveProfileFromToken(string $token): ?Candidate
    {
        // 1. Try resolving format: code-randomnonce (e.g. RM00004-a8f9c2d1b4 or RM-2024-0012-a8f9c2d1b4)
        if (str_contains($token, '-')) {
            $parts = explode('-', $token);
            if (count($parts) >= 2) {
                // Drop the trailing random nonce part
                array_pop($parts);
                $code = implode('-', $parts);

                $found = Candidate::with('photos')
                    ->where('candidate_code', $code)
                    ->orWhere('profile_id', $code)
                    ->orWhere('id', is_numeric($code) ? $code : 0)
                    ->first();

                if ($found) {
                    return $found;
                }
            }
        }

        // 2. Direct lookup by candidate code or ID
        $found = Candidate::with('photos')
            ->where('candidate_code', $token)
            ->orWhere('profile_id', $token)
            ->orWhere('id', is_numeric($token) ? $token : 0)
            ->first();

        if ($found) {
            return $found;
        }

        // 3. Fallback: try decoding old legacy crypt token if any
        try {
            $padded = str_pad(strtr($token, '-_', '+/'), strlen($token) % 4 ? strlen($token) + (4 - strlen($token) % 4) : strlen($token), '=', STR_PAD_RIGHT);
            $decrypted = Crypt::decryptString($padded);
            $data = json_decode($decrypted, true);
            
            if (is_array($data) && (! empty($data['id']) || ! empty($data['code']))) {
                return Candidate::with('photos')
                    ->where('id', $data['id'] ?? 0)
                    ->orWhere('candidate_code', $data['code'] ?? '')
                    ->orWhere('profile_id', $data['code'] ?? '')
                    ->first();
            }
        } catch (\Exception $e) {
            // Not a valid legacy token
        }

        return null;
    }

    /**
     * Dedicated Full Profile View Page (Stand-alone, fully responsive, shows all data transparently)
     */
    public function showProfile(Request $request, string $id)
    {
        /** @var Candidate $candidate */
        $candidate = Auth::user();

        // 1. Try to resolve via dynamic encrypted token
        $profile = self::resolveProfileFromToken($id);

        // 2. If not a valid encrypted token, locate by plain ID / code and immediately 302 redirect to a fresh newly generated dynamic URL
        if (! $profile) {
            $profile = Candidate::with('photos')
                ->where('candidate_code', $id)
                ->orWhere('profile_id', $id)
                ->orWhere('id', is_numeric($id) ? $id : 0)
                ->firstOrFail();

            return redirect()->route('matches.view-profile', ['id' => self::generateProfileToken($profile)]);
        }

        $profile->loadMissing('photos');

        // Check connection status
        $connection = ConnectionRequest::where(function ($q) use ($candidate, $profile) {
            $q->where('sender_id', $candidate->id)->where('receiver_id', $profile->id);
        })->orWhere(function ($q) use ($candidate, $profile) {
            $q->where('sender_id', $profile->id)->where('receiver_id', $candidate->id);
        })->first();

        $isAccepted = $connection && $connection->status === 'accepted';
        $isPending = $connection && $connection->status === 'pending';
        $isSentByMe = $isPending && $connection->sender_id === $candidate->id;
        $isReceivedByMe = $isPending && $connection->receiver_id === $candidate->id;

        // Check WhatsApp chat request status
        $wpChatRequest = WhatsAppChatRequest::where(function ($q) use ($candidate, $profile) {
            $q->where('sender_id', $candidate->id)->where('receiver_id', $profile->id);
        })->orWhere(function ($q) use ($candidate, $profile) {
            $q->where('sender_id', $profile->id)->where('receiver_id', $candidate->id);
        })->first();

        $isWpChatAccepted = $wpChatRequest && $wpChatRequest->status === 'accepted';
        $isWpChatPending = $wpChatRequest && $wpChatRequest->status === 'pending';
        $isWpChatSentByMe = $isWpChatPending && $wpChatRequest->sender_id === $candidate->id;
        $isWpChatReceivedByMe = $isWpChatPending && $wpChatRequest->receiver_id === $candidate->id;

        // 6-Hour Cooldown check for sender
        $isWpChatCooldown = false;
        $wpChatCooldownHours = 6;
        if ($wpChatRequest && $wpChatRequest->sender_id === $candidate->id && ! $isWpChatAccepted) {
            if ($wpChatRequest->updated_at && $wpChatRequest->updated_at->addHours(6)->isFuture()) {
                $isWpChatCooldown = true;
                $minutesLeft = (int) ceil(now()->diffInMinutes($wpChatRequest->updated_at->addHours(6)));
                $wpChatCooldownHours = max(1, ceil($minutesLeft / 60));
            }
        }

        // Check shortlist status
        $searchIds = [$id, (string) $profile->id, $profile->getDisplayCodeAttribute(), $profile->profile_id ?? '', $profile->candidate_code ?? ''];
        $searchIds = array_values(array_filter(array_unique($searchIds)));
        $isShortlisted = Shortlisted::where('candidate_id', $candidate->id)->whereIn('profile_id', $searchIds)->exists();

        // Photos
        $targetGender = $profile->gender ?? 'Female';
        $genderDir = strtolower($targetGender) === 'female' ? 'female' : 'male';
        $photo = asset("img/{$genderDir}/correct1.png");
        if (! empty($profile->profile_picture)) {
            if (str_starts_with($profile->profile_picture, 'http')) {
                $photo = $profile->profile_picture;
            } elseif (str_starts_with($profile->profile_picture, 'img/')) {
                $photo = asset($profile->profile_picture);
            } else {
                $photo = asset('storage/'.$profile->profile_picture);
            }
        }

        $allPhotos = [$photo];
        if ($profile->photos && $profile->photos->isNotEmpty()) {
            foreach ($profile->photos as $p) {
                $pUrl = $p->photo_path;
                $fullUrl = str_starts_with($pUrl, 'http') ? $pUrl : (str_starts_with($pUrl, 'img/') ? asset($pUrl) : asset('storage/'.$pUrl));
                if (! in_array($fullUrl, $allPhotos)) {
                    $allPhotos[] = $fullUrl;
                }
            }
        }

        if (count($allPhotos) < 3) {
            foreach (['correct1.png', 'correct2.png', 'side.png', 'stock.png', 'group.png'] as $imgName) {
                $fallbackUrl = asset("img/{$genderDir}/{$imgName}");
                if (! in_array($fallbackUrl, $allPhotos)) {
                    $allPhotos[] = $fallbackUrl;
                }
            }
        }

        // Match Score calculation
        $matchResult = $this->calculateMatchScore($candidate, $profile);

        return view('frontend.pages.profile_view', compact(
            'candidate',
            'profile',
            'isAccepted',
            'isPending',
            'isSentByMe',
            'isReceivedByMe',
            'isWpChatAccepted',
            'isWpChatPending',
            'isWpChatSentByMe',
            'isWpChatReceivedByMe',
            'isWpChatCooldown',
            'wpChatCooldownHours',
            'isShortlisted',
            'allPhotos',
            'photo',
            'matchResult'
        ));
    }

    /**
     * Send interest / Connect with match & dispatch WhatsApp notification to recipient
     */
    public function sendInterest(Request $request)
    {
        $request->validate([
            'profile_id' => 'required|string',
        ]);

        /** @var Candidate $candidate */
        $candidate = Auth::user();
        $profileId = $request->profile_id;

        // Locate receiver candidate
        $targetCandidate = Candidate::where('profile_id', $profileId)
            ->orWhere('candidate_code', $profileId)
            ->orWhere('id', is_numeric($profileId) ? $profileId : 0)
            ->first();

        if ($targetCandidate) {
            if ($targetCandidate->id === $candidate->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot send a connection request to yourself.',
                ], 422);
            }

            // Check if connection request is already pending
            $existing = ConnectionRequest::where('sender_id', $candidate->id)
                ->where('receiver_id', $targetCandidate->id)
                ->where('status', 'pending')
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => true,
                    'status' => 'pending',
                    'profile_id' => $targetCandidate->getDisplayCodeAttribute(),
                    'message' => "Connection request is already pending with {$targetCandidate->first_name}.",
                ]);
            }

            // Wallet Balance & Pending Commitment Verification
            $wallet = $candidate->getOrCreateWallet();
            $balance = (float) $wallet->avl_balance;

            // Count pending connection requests currently sent by candidate
            $pendingCount = ConnectionRequest::where('sender_id', $candidate->id)
                ->where('status', 'pending')
                ->count();

            $costPerRequest = 100.00;
            $committedAmount = $pendingCount * $costPerRequest;
            $usableBalance = $balance - $committedAmount;

            // 1. Overall Balance is less than ₹100
            if ($balance < $costPerRequest) {
                return response()->json([
                    'success' => false,
                    'insufficient_balance' => true,
                    'redirect' => route('wallet'),
                    'title' => 'Insufficient Wallet Balance',
                    'message' => 'Your current wallet balance is ₹' . number_format($balance, 2) . '. You need at least ₹100 to send a connection request. Please recharge your wallet to continue.',
                ], 400);
            }

            // 2. Usable balance exhausted by existing pending requests
            if ($usableBalance < $costPerRequest) {
                $requestsWord = $pendingCount === 1 ? 'request' : 'requests';
                return response()->json([
                    'success' => false,
                    'insufficient_balance' => true,
                    'redirect' => route('wallet'),
                    'title' => 'Insufficient Usable Balance',
                    'message' => "You already have {$pendingCount} pending connection {$requestsWord} reserving ₹" . number_format($committedAmount, 0) . " from your total balance of ₹" . number_format($balance, 2) . ". Your remaining usable balance is ₹" . number_format(max(0, $usableBalance), 2) . ", which is insufficient to send another connection request. Please recharge your wallet to continue.",
                ], 400);
            }

            // Save / Update connection request in database
            $connection = ConnectionRequest::updateOrCreate(
                [
                    'sender_id' => $candidate->id,
                    'receiver_id' => $targetCandidate->id,
                ],
                [
                    'status' => 'pending',
                    'responded_at' => null,
                ]
            );

            // Send WhatsApp notification carrying sender's name and profile details
            $this->dispatchConnectionRequestWhatsApp($candidate, $targetCandidate);

            return response()->json([
                'success' => true,
                'status' => 'pending',
                'profile_id' => $targetCandidate->getDisplayCodeAttribute(),
                'message' => "Connection request sent to {$targetCandidate->first_name}! A WhatsApp notification has been delivered.",
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Candidate profile not found.',
        ], 404);
    }

    /**
     * Respond to a Connection Request (Accept or Decline)
     */
    public function respondInterest(Request $request)
    {
        $request->validate([
            'profile_id' => 'required|string',
            'action' => 'required|in:accept,decline',
        ]);

        /** @var Candidate $candidate */
        $candidate = Auth::user();
        $profileId = $request->profile_id;
        $action = $request->action;

        $targetCandidate = self::resolveProfileFromToken($profileId);
        if (! $targetCandidate) {
            $targetCandidate = Candidate::where('profile_id', $profileId)
                ->orWhere('candidate_code', $profileId)
                ->orWhere('id', is_numeric($profileId) ? $profileId : 0)
                ->first();
        }

        if (! $targetCandidate) {
            return response()->json([
                'success' => false,
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        // Find existing connection request where target sent to current user or vice-versa
        $connection = ConnectionRequest::where(function ($q) use ($candidate, $targetCandidate) {
            $q->where('sender_id', $targetCandidate->id)->where('receiver_id', $candidate->id);
        })->orWhere(function ($q) use ($candidate, $targetCandidate) {
            $q->where('sender_id', $candidate->id)->where('receiver_id', $targetCandidate->id);
        })->first();

        if (! $connection) {
            $connection = ConnectionRequest::create([
                'sender_id' => $targetCandidate->id,
                'receiver_id' => $candidate->id,
                'status' => $action === 'accept' ? 'accepted' : 'declined',
                'responded_at' => now(),
            ]);
        } else {
            $connection->update([
                'status' => $action === 'accept' ? 'accepted' : 'declined',
                'responded_at' => now(),
            ]);
        }

        if ($action === 'accept') {
            $requester = ($connection->sender_id === $candidate->id) ? $targetCandidate : (Candidate::find($connection->sender_id) ?? $targetCandidate);
            $requesterWallet = $requester->getOrCreateWallet();

            if ((float) $requesterWallet->avl_balance >= 100.00) {
                // Deduct ₹100 from requester's wallet & create debit transaction record
                try {
                    $requesterWallet->avl_balance = (float) $requesterWallet->avl_balance - 100.00;
                    $requesterWallet->save();

                    $requesterWallet->transactions()->create([
                        'candidate_id' => $requester->id,
                        'transaction_id' => 'TXN-'.strtoupper(\Illuminate\Support\Str::random(10)),
                        'type' => 'debit',
                        'amount' => 100.00,
                        'balance_after' => $requesterWallet->avl_balance,
                        'title' => 'Match Connection Accepted',
                        'description' => "Connection request accepted by {$candidate->first_name} ({$candidate->getDisplayCodeAttribute()}). Full profile & contact details unlocked.",
                        'category' => 'Connection Fee',
                        'status' => 'completed',
                        'payment_method' => 'Wallet Balance',
                    ]);
                } catch (\Exception $e) {
                    Log::error('Wallet debit on accept error: '.$e->getMessage());
                }
            }

            // Always dispatch Acceptance WhatsApp Notification (Template: HXd6d0204ec25374a29cc5f3b818eccd69) to the requester
            $this->dispatchRequestAcceptedWhatsApp($candidate, $requester);

            return response()->json([
                'success' => true,
                'status' => 'accepted',
                'profile_id' => $targetCandidate->getDisplayCodeAttribute(),
                'message' => "You have accepted {$targetCandidate->first_name}'s connection request! All profile details are now unlocked in your Accepted tab.",
            ]);
        }

        return response()->json([
            'success' => true,
            'status' => 'declined',
            'profile_id' => $targetCandidate->getDisplayCodeAttribute(),
            'message' => "Connection request from {$targetCandidate->first_name} was declined.",
        ]);
    }

    /**
     * Dispatch WhatsApp Notification when a connection request is accepted
     */
    private function dispatchRequestAcceptedWhatsApp(Candidate $accepter, Candidate $requester): void
    {
        if (empty($requester->mobile)) {
            return;
        }

        try {
            $apiKey = env('TWILIO_SID');
            $apiSecret = env('TWILIO_AUTH_TOKEN');
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');

            if ($apiKey && $apiSecret && $accountSid && $twilioNumber) {
                $twilio = new Client($apiKey, $apiSecret, $accountSid);

                $cleanMobile = preg_replace('/[^0-9]/', '', $requester->mobile);
                if (strlen($cleanMobile) === 10) {
                    $formattedMobile = 'whatsapp:+91'.$cleanMobile;
                } elseif (strlen($cleanMobile) === 12 && str_starts_with($cleanMobile, '91')) {
                    $formattedMobile = 'whatsapp:+'.$cleanMobile;
                } else {
                    $formattedMobile = 'whatsapp:+91'.ltrim($cleanMobile, '0');
                }

                // WhatsApp Meta template for connection request accept
                $templateSid = 'HXd6d0204ec25374a29cc5f3b818eccd69';

                $accepterName = trim(($accepter->first_name ?? 'Candidate').' '.($accepter->last_name ?? ''));
                $accepterProfession = $accepter->profession ?: ($accepter->highest_qualification ?: 'Professional');
                $accepterCity = $accepter->city ?: ($accepter->state ?: 'India');
                $accepterCode = $accepter->getDisplayCodeAttribute();

                $contentVariables = json_encode([
                    '1' => $requester->first_name ?? 'Candidate',
                    '2' => $accepterName,
                    '3' => $accepterCode,
                    '4' => "{$accepterProfession}, {$accepterCity}",
                ]);

                $twilio->messages->create(
                    $formattedMobile,
                    [
                        'from' => $twilioNumber,
                        'contentSid' => $templateSid,
                        'contentVariables' => $contentVariables,
                    ]
                );

                Log::info("WhatsApp Request Accepted notification sent to {$requester->mobile} from accepter {$accepterCode}");
            }
        } catch (\Exception $e) {
            Log::error('Twilio WhatsApp Request Accepted Error: '.$e->getMessage());
        }
    }

    /**
     * Dispatch WhatsApp Notification when connection request is accepted but requester has insufficient wallet balance
     */
    private function dispatchUrgentRechargeWhatsApp(Candidate $accepter, Candidate $requester): void
    {
        if (empty($requester->mobile)) {
            return;
        }

        try {
            $apiKey = env('TWILIO_SID');
            $apiSecret = env('TWILIO_AUTH_TOKEN');
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');

            if ($apiKey && $apiSecret && $accountSid && $twilioNumber) {
                $twilio = new Client($apiKey, $apiSecret, $accountSid);

                $cleanMobile = preg_replace('/[^0-9]/', '', $requester->mobile);
                if (strlen($cleanMobile) === 10) {
                    $formattedMobile = 'whatsapp:+91'.$cleanMobile;
                } elseif (strlen($cleanMobile) === 12 && str_starts_with($cleanMobile, '91')) {
                    $formattedMobile = 'whatsapp:+'.$cleanMobile;
                } else {
                    $formattedMobile = 'whatsapp:+91'.ltrim($cleanMobile, '0');
                }

                // WhatsApp Meta template: rm_urgent_match_recharge
                $templateSid = 'HX6a855e150d09a7ae3b91759d160f1408';

                $accepterName = trim(($accepter->first_name ?? 'Candidate').' '.($accepter->last_name ?? ''));
                $accepterProfession = $accepter->profession ?: ($accepter->highest_qualification ?: 'Professional');
                $accepterCity = $accepter->city ?: ($accepter->state ?: 'India');
                $accepterCode = $accepter->getDisplayCodeAttribute();

                $contentVariables = json_encode([
                    '1' => $requester->first_name ?? 'Candidate',
                    '2' => $accepterName,
                    '3' => $accepterCode,
                    '4' => "{$accepterProfession}, {$accepterCity}",
                ]);

                $twilio->messages->create(
                    $formattedMobile,
                    [
                        'from' => $twilioNumber,
                        'contentSid' => $templateSid,
                        'contentVariables' => $contentVariables,
                    ]
                );

                Log::info("WhatsApp Urgent Recharge notification sent to {$requester->mobile} for accepted match {$accepterCode}");
            }
        } catch (\Exception $e) {
            Log::error('Twilio WhatsApp Urgent Recharge Error: '.$e->getMessage());
        }
    }

    /**
     * Dispatch WhatsApp Notification for Connection Request
     */
    private function dispatchConnectionRequestWhatsApp(Candidate $sender, Candidate $receiver): void
    {
        if (empty($receiver->mobile)) {
            return;
        }

        try {
            $apiKey = env('TWILIO_SID');
            $apiSecret = env('TWILIO_AUTH_TOKEN');
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');

            if ($apiKey && $apiSecret && $accountSid && $twilioNumber) {
                $twilio = new Client($apiKey, $apiSecret, $accountSid);
                $formattedMobile = 'whatsapp:+91'.ltrim($receiver->mobile, '0');

                // WhatsApp Meta template: rm_connection_request
                $templateSid = env('TWILIO_WHATSAPP_CONNECTION_REQUEST_TEMPLATE_SID', 'HX43b53a132cb7e4fc3b0e0e8d153c60f4');

                $senderName = trim(($sender->first_name ?? 'Candidate').' '.($sender->last_name ?? ''));
                $senderAge = $sender->dob ? Carbon::parse($sender->dob)->age : '26';
                $senderHeight = $sender->height ?? "5' 8\"";
                $senderProfession = $sender->profession ?? ($sender->highest_qualification ?? 'Professional');
                $senderCity = $sender->city ?? ($sender->state ?? 'India');
                $senderCode = $sender->getDisplayCodeAttribute();

                $contentVariables = json_encode([
                    '1' => $receiver->first_name ?? 'Candidate',
                    '2' => $senderName,
                    '3' => "{$senderAge} yrs, {$senderHeight}",
                    '4' => "{$senderProfession}, {$senderCity}",
                    '5' => $senderCode,
                ]);

                $twilio->messages->create(
                    $formattedMobile,
                    [
                        'from' => $twilioNumber,
                        'contentSid' => $templateSid,
                        'contentVariables' => $contentVariables,
                    ]
                );

                Log::info("WhatsApp Connection Request sent to {$receiver->mobile} for sender {$senderCode}");
            }
        } catch (\Exception $e) {
            Log::error('Twilio WhatsApp Connection Request Error: '.$e->getMessage());
        }
    }

    /**
     * Request direct WhatsApp chat with an accepted candidate
     */
    public function requestWhatsAppChat(Request $request)
    {
        $request->validate([
            'profile_id' => 'required|string',
        ]);

        /** @var Candidate $candidate */
        $candidate = Auth::user();
        $profileId = $request->profile_id;

        $targetCandidate = self::resolveProfileFromToken($profileId);
        if (! $targetCandidate) {
            $targetCandidate = Candidate::where('candidate_code', $profileId)
                ->orWhere('profile_id', $profileId)
                ->orWhere('id', is_numeric($profileId) ? $profileId : 0)
                ->first();
        }

        if (! $targetCandidate) {
            return response()->json([
                'success' => false,
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        // Check 6-hour cooldown if a request was already sent by candidate to this target
        $existing = WhatsAppChatRequest::where('sender_id', $candidate->id)
            ->where('receiver_id', $targetCandidate->id)
            ->first();

        if ($existing && $existing->updated_at && $existing->updated_at->addHours(6)->isFuture()) {
            $minutesLeft = (int) ceil(now()->diffInMinutes($existing->updated_at->addHours(6)));
            $hoursLeft = max(1, ceil($minutesLeft / 60));
            $hoursText = $hoursLeft > 1 ? "{$hoursLeft} hours" : "{$minutesLeft} minutes";

            return response()->json([
                'success' => false,
                'cooldown' => true,
                'retry_after_minutes' => $minutesLeft,
                'message' => "You have already requested a WhatsApp chat with {$targetCandidate->first_name}. Please wait {$hoursText} before sending another request.",
            ], 429);
        }

        // Store or update WhatsApp Chat Request record with updated timestamp
        WhatsAppChatRequest::updateOrCreate(
            [
                'sender_id' => $candidate->id,
                'receiver_id' => $targetCandidate->id,
            ],
            [
                'status' => 'pending',
                'responded_at' => null,
                'updated_at' => now(),
            ]
        );

        // Dispatch WhatsApp notification via Twilio Meta Template
        $this->dispatchWhatsAppChatRequestNotification($candidate, $targetCandidate);

        return response()->json([
            'success' => true,
            'status' => 'pending',
            'cooldown_hours' => 6,
            'message' => "WhatsApp chat request sent to {$targetCandidate->first_name}! A notification has been delivered to their WhatsApp.",
        ]);
    }

    /**
     * Respond to a WhatsApp Chat Request (Accept or Decline)
     */
    public function respondWhatsAppChat(Request $request)
    {
        $request->validate([
            'profile_id' => 'required|string',
            'action' => 'required|in:accept,decline',
        ]);

        /** @var Candidate $candidate */
        $candidate = Auth::user();
        $profileId = $request->profile_id;
        $action = $request->action;

        $targetCandidate = self::resolveProfileFromToken($profileId);
        if (! $targetCandidate) {
            $targetCandidate = Candidate::where('candidate_code', $profileId)
                ->orWhere('profile_id', $profileId)
                ->orWhere('id', is_numeric($profileId) ? $profileId : 0)
                ->first();
        }

        if (! $targetCandidate) {
            return response()->json([
                'success' => false,
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        // Locate existing chat request
        $chatRequest = WhatsAppChatRequest::where(function ($q) use ($candidate, $targetCandidate) {
            $q->where('sender_id', $targetCandidate->id)->where('receiver_id', $candidate->id);
        })->orWhere(function ($q) use ($candidate, $targetCandidate) {
            $q->where('sender_id', $candidate->id)->where('receiver_id', $targetCandidate->id);
        })->first();

        if (! $chatRequest) {
            $chatRequest = WhatsAppChatRequest::create([
                'sender_id' => $targetCandidate->id,
                'receiver_id' => $candidate->id,
                'status' => $action === 'accept' ? 'accepted' : 'declined',
                'responded_at' => now(),
            ]);
        } else {
            $chatRequest->update([
                'status' => $action === 'accept' ? 'accepted' : 'declined',
                'responded_at' => now(),
            ]);
        }

        // When accepted, dispatch WhatsApp Chat Acceptance notification (Template: HX795c717c904849c2869c1c5dea6b2d52) to the requester
        if ($action === 'accept') {
            $this->dispatchWhatsAppChatAcceptedNotification($candidate, $targetCandidate);
        }

        $cleanMobile = preg_replace('/[^0-9]/', '', $targetCandidate->mobile ?? '');
        $unmaskedMobile = '+91 ' . preg_replace('/(\d{5})(\d{5})/', '$1 $2', $cleanMobile);

        return response()->json([
            'success' => true,
            'status' => $chatRequest->status,
            'action' => $action,
            'profile_id' => $targetCandidate->getDisplayCodeAttribute(),
            'unmasked_mobile' => $unmaskedMobile,
            'clean_mobile' => $cleanMobile,
            'whatsapp_url' => 'https://wa.me/91' . ltrim($cleanMobile, '0'),
            'message' => $action === 'accept' 
                ? "You accepted {$targetCandidate->first_name}'s WhatsApp chat request! Direct WhatsApp chat is now unlocked."
                : "WhatsApp chat request from {$targetCandidate->first_name} was declined.",
        ]);
    }

    /**
     * Dispatch WhatsApp Notification when a WhatsApp Chat Request is accepted (Template: HX795c717c904849c2869c1c5dea6b2d52)
     */
    private function dispatchWhatsAppChatAcceptedNotification(Candidate $accepter, Candidate $requester): void
    {
        if (empty($requester->mobile)) {
            return;
        }

        try {
            $apiKey = env('TWILIO_SID');
            $apiSecret = env('TWILIO_AUTH_TOKEN');
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');

            if ($apiKey && $apiSecret && $accountSid && $twilioNumber) {
                $twilio = new Client($apiKey, $apiSecret, $accountSid);

                $cleanRequesterMobile = preg_replace('/[^0-9]/', '', $requester->mobile);
                if (strlen($cleanRequesterMobile) === 10) {
                    $formattedMobile = 'whatsapp:+91'.$cleanRequesterMobile;
                } elseif (strlen($cleanRequesterMobile) === 12 && str_starts_with($cleanRequesterMobile, '91')) {
                    $formattedMobile = 'whatsapp:+'.$cleanRequesterMobile;
                } else {
                    $formattedMobile = 'whatsapp:+91'.ltrim($cleanRequesterMobile, '0');
                }

                $cleanAccepterMobile = ltrim(preg_replace('/[^0-9]/', '', $accepter->mobile ?? ''), '0');
                if (strlen($cleanAccepterMobile) > 10 && str_starts_with($cleanAccepterMobile, '91')) {
                    $cleanAccepterMobile = substr($cleanAccepterMobile, 2);
                }

                // WhatsApp Meta template: rm_wp_chat_accept (SID: HX795c717c904849c2869c1c5dea6b2d52)
                $templateSid = 'HX795c717c904849c2869c1c5dea6b2d52';

                $requesterName = $requester->first_name ?? 'Candidate';
                $accepterName = trim(($accepter->first_name ?? 'Candidate').' '.($accepter->last_name ?? ''));
                $accepterCode = $accepter->getDisplayCodeAttribute();

                $contentVariables = json_encode([
                    '1' => $requesterName,
                    '2' => $accepterName,
                    '3' => $accepterCode,
                ]);

                $twilio->messages->create(
                    $formattedMobile,
                    [
                        'from' => $twilioNumber,
                        'contentSid' => $templateSid,
                        'contentVariables' => $contentVariables,
                    ]
                );

                Log::info("WhatsApp Chat Accepted notification sent to {$requester->mobile} for accepter {$accepterCode}");
            }
        } catch (\Exception $e) {
            Log::error('Twilio WhatsApp Chat Accepted Error: '.$e->getMessage());
        }
    }

    /**
     * Dispatch WhatsApp Notification for WhatsApp Chat Request (Template: HX3a8ae54665631a6314a65aa6dded55e8)
     */
    private function dispatchWhatsAppChatRequestNotification(Candidate $sender, Candidate $receiver): void
    {
        if (empty($receiver->mobile)) {
            return;
        }

        try {
            $apiKey = env('TWILIO_SID');
            $apiSecret = env('TWILIO_AUTH_TOKEN');
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');

            if ($apiKey && $apiSecret && $accountSid && $twilioNumber) {
                $twilio = new Client($apiKey, $apiSecret, $accountSid);

                $cleanMobile = preg_replace('/[^0-9]/', '', $receiver->mobile);
                if (strlen($cleanMobile) === 10) {
                    $formattedMobile = 'whatsapp:+91'.$cleanMobile;
                } elseif (strlen($cleanMobile) === 12 && str_starts_with($cleanMobile, '91')) {
                    $formattedMobile = 'whatsapp:+'.$cleanMobile;
                } else {
                    $formattedMobile = 'whatsapp:+91'.ltrim($cleanMobile, '0');
                }

                // WhatsApp Meta template: rm_whatsapp_chat_request
                $templateSid = 'HX3a8ae54665631a6314a65aa6dded55e8';

                $receiverName = $receiver->first_name ?? 'Candidate';
                $senderName = trim(($sender->first_name ?? 'Candidate').' '.($sender->last_name ?? ''));
                $senderProfession = $sender->profession ?: ($sender->highest_qualification ?: 'Professional');
                $senderCity = $sender->city ?: ($sender->state ?: 'India');
                $senderCode = $sender->getDisplayCodeAttribute();

                $contentVariables = json_encode([
                    '1' => $receiverName,
                    '2' => $senderName,
                    '3' => $senderCode,
                    '4' => "{$senderProfession}, {$senderCity}",
                ]);

                $twilio->messages->create(
                    $formattedMobile,
                    [
                        'from' => $twilioNumber,
                        'contentSid' => $templateSid,
                        'contentVariables' => $contentVariables,
                    ]
                );

                Log::info("WhatsApp Chat Request notification sent to {$receiver->mobile} for sender {$senderCode}");
            }
        } catch (\Exception $e) {
            Log::error('Twilio WhatsApp Chat Request Error: '.$e->getMessage());
        }
    }

    /**
     * Shortlist / Favorite match (stores into shortlisted table)
     */
    public function toggleShortlist(Request $request)
    {
        $request->validate([
            'profile_id' => 'required|string',
        ]);

        /** @var Candidate $candidate */
        $candidate = Auth::user();
        $profileId = $request->profile_id;

        $targetCandidate = Candidate::where('profile_id', $profileId)
            ->orWhere('candidate_code', $profileId)
            ->orWhere('id', is_numeric($profileId) ? $profileId : 0)
            ->first();

        $searchIds = [$profileId];
        if ($targetCandidate) {
            $searchIds[] = (string) $targetCandidate->id;
            $searchIds[] = $targetCandidate->getDisplayCodeAttribute();
            $searchIds[] = $targetCandidate->profile_id ?? '';
            $searchIds[] = $targetCandidate->candidate_code ?? '';
        }
        $searchIds = array_values(array_filter(array_unique($searchIds)));

        $existing = Shortlisted::where('candidate_id', $candidate->id)
            ->whereIn('profile_id', $searchIds)
            ->first();

        if ($existing) {
            $existing->delete();
            $shortlisted = false;
            $message = 'Profile removed from your shortlist.';
        } else {
            Shortlisted::create([
                'candidate_id' => $candidate->id,
                'profile_id' => $targetCandidate ? $targetCandidate->getDisplayCodeAttribute() : $profileId,
            ]);
            $shortlisted = true;
            $message = 'Profile saved to your shortlist.';
        }

        $shortlistedCount = Shortlisted::where('candidate_id', $candidate->id)->count();

        return response()->json([
            'success' => true,
            'shortlisted' => $shortlisted,
            'count' => $shortlistedCount,
            'message' => $message,
        ]);
    }

    /**
     * Generate structured matches list from DB candidates with real dynamic data-wise match percentage
     */
    private function getMatchesData(
        Candidate $candidate,
        string $targetGender,
        string $tab,
        array $shortlistedIds = [],
        array $sentInterestIds = [],
        array $receivedInterestIds = [],
        array $acceptedCandidateIds = []
    ): array {
        $query = Candidate::with('photos')
            ->where('gender', $targetGender)
            ->where('id', '!=', $candidate->id);

        // Determine candidate's religion matching criteria
        $userReligion = trim($candidate->religion ?? '');
        $prefReligion = trim($candidate->pref_religion ?? '');

        $targetReligions = [];
        if (! empty($prefReligion)) {
            $targetReligions = array_values(array_filter(array_map('trim', preg_split('/[\/,|]+/', $prefReligion))));
        } elseif (! empty($userReligion)) {
            $targetReligions = [$userReligion];
        }

        if (! empty($targetReligions)) {
            $query->where(function ($q) use ($targetReligions, $tab, $acceptedCandidateIds, $shortlistedIds) {
                $q->where(function ($sub) use ($targetReligions) {
                    foreach ($targetReligions as $r) {
                        $sub->orWhere('religion', 'LIKE', '%'.$r.'%');
                    }
                });

                // Preserve explicitly connected or shortlisted profiles in respective tabs
                if ($tab === 'accepted' && ! empty($acceptedCandidateIds)) {
                    $q->orWhereIn('id', $acceptedCandidateIds);
                } elseif ($tab === 'shortlisted' && ! empty($shortlistedIds)) {
                    $q->orWhereIn('id', $shortlistedIds);
                }
            });
        }

        $dbCandidates = $query->get();

        $pool = [];
        $seenCandidateIds = [];

        foreach ($dbCandidates as $index => $c) {
            if (in_array($c->id, $seenCandidateIds)) {
                continue;
            }
            $seenCandidateIds[] = $c->id;

            $age = $c->dob ? Carbon::parse($c->dob)->age : (24 + ($c->id % 8));
            $profileCode = $c->getDisplayCodeAttribute();

            // Determine primary image url
            $photo = asset('img/'.(strtolower($targetGender) === 'female' ? 'female' : 'male').'/correct'.(($index % 2) + 1).'.png');
            if (! empty($c->profile_picture)) {
                if (str_starts_with($c->profile_picture, 'http')) {
                    $photo = $c->profile_picture;
                } elseif (str_starts_with($c->profile_picture, 'img/')) {
                    $photo = asset($c->profile_picture);
                } else {
                    $photo = asset('storage/'.$c->profile_picture);
                }
            }

            // Build list of all related photos for gallery
            $allPhotos = [$photo];
            if ($c->photos && $c->photos->isNotEmpty()) {
                foreach ($c->photos as $p) {
                    $pUrl = $p->photo_path;
                    if (str_starts_with($pUrl, 'http')) {
                        $fullUrl = $pUrl;
                    } elseif (str_starts_with($pUrl, 'img/')) {
                        $fullUrl = asset($pUrl);
                    } else {
                        $fullUrl = asset('storage/'.$pUrl);
                    }
                    if (! in_array($fullUrl, $allPhotos)) {
                        $allPhotos[] = $fullUrl;
                    }
                }
            }

            // Guarantee 3-4 gallery photos if candidate has few
            if (count($allPhotos) < 3) {
                $genderDir = strtolower($targetGender) === 'female' ? 'female' : 'male';
                foreach (['correct1.png', 'correct2.png', 'side.png', 'stock.png', 'group.png'] as $imgName) {
                    $fallbackUrl = asset("img/{$genderDir}/{$imgName}");
                    if (! in_array($fallbackUrl, $allPhotos)) {
                        $allPhotos[] = $fallbackUrl;
                    }
                }
            }

            // Calculate dynamic data-wise match percentage & reasons
            $matchResult = $this->calculateMatchScore($candidate, $c);
            $matchScore = $matchResult['score'];
            $matchReasons = $matchResult['reasons'];

            $isAccepted = in_array($c->id, $acceptedCandidateIds) || in_array($profileCode, $acceptedCandidateIds) || in_array((string)$c->id, $acceptedCandidateIds);
            $isReceived = in_array($c->id, $receivedInterestIds) || in_array($profileCode, $receivedInterestIds) || in_array((string)$c->id, $receivedInterestIds);
            $isSent = in_array($profileCode, $sentInterestIds) || in_array((string) $c->id, $sentInterestIds) || in_array($c->id, $sentInterestIds);

            $requestType = $isAccepted ? 'accepted' : ($isReceived ? 'received' : ($isSent ? 'sent' : 'none'));

            $badge = $isAccepted ? 'Accepted Connection' : (
                $isReceived ? '📥 Interest Received' : (
                    $isSent ? '📤 Request Sent' : (
                        $matchScore >= 95 ? 'Top Recommendation' : (
                            $matchScore >= 90 ? 'High Compatibility' : (
                                $c->selfie_verified ? 'Verified Profile' : 'Compatible Match'
                            )
                        )
                    )
                )
            );

            // Full Transparent Details for Accepted Connections
            $fullDetails = [
                'mobile' => $c->mobile ? ('+91 ' . preg_replace('/(\d{5})(\d{5})/', '$1 $2', $c->mobile)) : '+91 98201 49842',
                'raw_mobile' => $c->mobile ? ltrim($c->mobile, '0') : '9820149842',
                'email' => $c->email ?: (strtolower($c->first_name ?? 'candidate') . '@gmail.com'),
                'full_address' => $c->full_address ?: ($c->city . ', ' . $c->state),
                'police_st' => $c->police_st ?: 'Local Station',
                'pincode' => $c->pincode ?: '400001',
                'about_yourself' => $c->about_yourself ?: 'I am a warm, values-driven individual looking for a supportive life partner.',
                'mother_profession' => $c->mother_profession ?: 'Homemaker',
                'father_profession' => $c->father_profession ?: 'Businessman',
                'family_location' => $c->family_location ?: ($c->city . ', ' . $c->state),
                'sisters_count' => $c->sisters_count ?? '0',
                'brothers_count' => $c->brothers_count ?? '1',
                'family_financial_status' => $c->family_financial_status ?: 'Upper Middle Class',
                'gothra' => $c->gothra ?: 'Kashyap',
                'manglik' => $c->manglik ?: 'Non-Manglik',
                'time_of_birth' => $c->time_of_birth ?: '08:30 AM',
                'city_of_birth' => $c->city_of_birth ?: $c->city,
                'blood_group' => $c->blood_group ?: 'O+',
                'college_name' => $c->college_name ?: 'University of Mumbai',
                'college_address' => $c->college_address ?: $c->city,
                'company_address' => $c->company_address ?: ($c->city . ', ' . $c->state),
                'working_with' => $c->working_with ?: 'Private Company',
                'hobbies' => is_array($c->hobbies_interests) ? $c->hobbies_interests : ['Travelling', 'Reading', 'Music', 'Fitness'],
            ];

            $pool[] = [
                'id' => $profileCode,
                'db_id' => $c->id,
                'profile_url' => route('matches.view-profile', ['id' => self::generateProfileToken($c)]),
                'first_name' => $c->first_name ?? 'Candidate',
                'last_name' => $c->last_name ?? '',
                'age' => $age,
                'height' => $c->height ?? "5' 7\"",
                'religion' => $c->religion ?? 'Hindu',
                'community' => $c->community ?? 'General',
                'mother_tongue' => $c->mother_tongue ?? 'Hindi',
                'highest_qualification' => $c->highest_qualification ?? 'Graduate',
                'profession' => $c->profession ?? 'Professional',
                'company_name' => $c->company_name ?? 'Reputed Company',
                'annual_income' => $c->annual_income ?? '₹ 20 - 30 Lakh',
                'city' => $c->city ?? 'Mumbai',
                'state' => $c->state ?? 'Maharashtra',
                'diet' => $c->diet ?? 'Vegetarian',
                'photo' => $photo,
                'photos' => $allPhotos,
                'match_score' => $matchScore,
                'match_reasons' => array_slice($matchReasons, 0, 3),
                'badge' => $badge,
                'verified' => (bool) $c->selfie_verified,
                'active_ago' => ($index % 2 === 0) ? 'Online now' : 'Active '.(($index % 5) + 1).' hours ago',
                'distance' => (4 + (($c->id * 2) % 20)).' km away',
                'is_accepted' => $isAccepted,
                'is_interest_sent' => $isSent,
                'is_interest_received' => $isReceived,
                'request_type' => $requestType,
                'details' => $fullDetails,
            ];
        }

        // Sort pool by match_score descending so top matching profiles show first
        usort($pool, fn ($a, $b) => $b['match_score'] <=> $a['match_score']);

        // Filter based on tab
        if ($tab === 'shortlisted') {
            $filtered = array_filter($pool, fn ($m) => in_array($m['id'], $shortlistedIds) || in_array((string)$m['db_id'], $shortlistedIds) || in_array($m['db_id'], $shortlistedIds));
        } elseif ($tab === 'accepted') {
            $filtered = array_filter($pool, fn ($m) => $m['is_accepted'] || $m['request_type'] === 'accepted');
        } elseif ($tab === 'my_matches') {
            // 'my_matches' ONLY contains candidates user sent interest to and not yet accepted
            $filtered = array_filter($pool, fn ($m) => $m['request_type'] === 'sent' && ! $m['is_accepted']);
        } else {
            // Today's Picks: ONLY fresh recommendations that haven't been contacted or accepted
            $filtered = array_filter($pool, fn ($m) => ! $m['is_accepted'] && $m['request_type'] === 'none');
        }

        return array_values($filtered);
    }

    /**
     * Calculate comprehensive data-wise match percentage and reasons
     */
    private function calculateMatchScore(Candidate $me, Candidate $other): array
    {
        $score = 50; // Base score for opposite gender compatibility
        $matchReasons = [];

        // 1. Religion & Community (Max 18 points)
        if (! empty($other->religion)) {
            if ((! empty($me->religion) && strcasecmp($me->religion, $other->religion) === 0) ||
                (! empty($me->pref_religion) && strcasecmp($me->pref_religion, $other->religion) === 0)) {
                $score += 10;
                $matchReasons[] = $other->religion.' Religion';
            }
        }
        if (! empty($other->community)) {
            if ((! empty($me->community) && strcasecmp($me->community, $other->community) === 0) ||
                (! empty($me->pref_community) && strcasecmp($me->pref_community, $other->community) === 0)) {
                $score += 8;
                $matchReasons[] = $other->community.' Community';
            }
        }

        // 2. Location Compatibility (Max 12 points)
        if (! empty($other->city) && (
            (! empty($me->city) && strcasecmp($me->city, $other->city) === 0) ||
            (! empty($me->pref_city) && strcasecmp($me->pref_city, $other->city) === 0)
        )) {
            $score += 12;
            $matchReasons[] = $other->city.' Resident';
        } elseif (! empty($other->state) && (
            (! empty($me->state) && strcasecmp($me->state, $other->state) === 0) ||
            (! empty($me->pref_state) && strcasecmp($me->pref_state, $other->state) === 0)
        )) {
            $score += 8;
            $matchReasons[] = $other->state.' State';
        }

        // 3. Diet & Lifestyle (Max 10 points)
        if (! empty($other->diet) && (
            (! empty($me->diet) && strcasecmp($me->diet, $other->diet) === 0) ||
            (! empty($me->pref_diet) && strcasecmp($me->pref_diet, $other->diet) === 0)
        )) {
            $score += 10;
            $matchReasons[] = $other->diet.' Diet';
        }

        // 4. Mother Tongue (Max 8 points)
        if (! empty($other->mother_tongue) && (
            (! empty($me->mother_tongue) && strcasecmp($me->mother_tongue, $other->mother_tongue) === 0) ||
            (! empty($me->pref_mother_tongue) && strcasecmp($me->pref_mother_tongue, $other->mother_tongue) === 0)
        )) {
            $score += 8;
            $matchReasons[] = $other->mother_tongue.' Tongue';
        }

        // 5. Marital Status (Max 8 points)
        if (! empty($other->marital_status)) {
            if ((! empty($me->marital_status) && strcasecmp($me->marital_status, $other->marital_status) === 0) ||
                (! empty($me->pref_marital_status) && strcasecmp($me->pref_marital_status, $other->marital_status) === 0) ||
                (strtolower($other->marital_status) === 'never married' && empty($me->marital_status))) {
                $score += 8;
            }
        }

        // 6. Education Compatibility (Max 8 points)
        if (! empty($other->highest_qualification)) {
            if ((! empty($me->highest_qualification) && strcasecmp($me->highest_qualification, $other->highest_qualification) === 0) ||
                (! empty($me->pref_education) && strcasecmp($me->pref_education, $other->highest_qualification) === 0)) {
                $score += 8;
                $matchReasons[] = 'Education Match';
            } else {
                $score += 4;
            }
        }

        // 7. Career & Profession (Max 6 points)
        if (! empty($other->working_with) && (
            (! empty($me->working_with) && strcasecmp($me->working_with, $other->working_with) === 0) ||
            (! empty($me->pref_working_with) && strcasecmp($me->pref_working_with, $other->working_with) === 0)
        )) {
            $score += 4;
            $matchReasons[] = 'Profession Match';
        }
        if (! empty($other->annual_income)) {
            $score += 2;
        }

        // 8. Shared Hobbies & Interests (Max 10 points)
        $myHobbies = is_array($me->hobbies_interests) ? $me->hobbies_interests : [];
        $otherHobbies = is_array($other->hobbies_interests) ? $other->hobbies_interests : [];
        if (! empty($myHobbies) && ! empty($otherHobbies)) {
            $sharedHobbies = array_intersect(
                array_map('strtolower', array_map('trim', $myHobbies)),
                array_map('strtolower', array_map('trim', $otherHobbies))
            );
            $sharedCount = count($sharedHobbies);
            if ($sharedCount > 0) {
                $score += min(10, $sharedCount * 4);
                $matchReasons[] = $sharedCount.' Mutual '.($sharedCount === 1 ? 'Hobby' : 'Hobbies');
            }
        }

        // 9. Age Compatibility (Max 8 points)
        $myAge = $me->dob ? Carbon::parse($me->dob)->age : null;
        $otherAge = $other->dob ? Carbon::parse($other->dob)->age : null;
        if ($otherAge) {
            if (! empty($me->pref_age_min) && ! empty($me->pref_age_max)) {
                if ($otherAge >= $me->pref_age_min && $otherAge <= $me->pref_age_max) {
                    $score += 8;
                    $matchReasons[] = 'Age Preference Match';
                }
            } elseif ($myAge) {
                $ageDiff = abs($myAge - $otherAge);
                if ($ageDiff <= 3) {
                    $score += 8;
                    $matchReasons[] = 'Ideal Age Match';
                } elseif ($ageDiff <= 6) {
                    $score += 5;
                }
            }
        }

        // 10. Profile Verification Bonus (Max 4 points)
        if ($other->selfie_verified) {
            $score += 4;
            $matchReasons[] = 'Verified Profile';
        }

        // Clamp final score between 65% and 99%
        $finalScore = min(99, max(65, (int) round($score)));

        if (empty($matchReasons)) {
            $matchReasons = ['High Compatibility', 'Personality Match'];
        }

        return [
            'score' => $finalScore,
            'reasons' => array_values(array_unique($matchReasons)),
        ];
    }
}
