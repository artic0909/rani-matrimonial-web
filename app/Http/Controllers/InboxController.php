<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\ConnectionRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    /**
     * Display Candidate Inbox with received connection requests
     */
    public function index(Request $request)
    {
        /** @var Candidate $candidate */
        $candidate = Auth::user();
        $subTab = $request->query('tab', 'received');
        if (! in_array($subTab, ['received', 'accepted', 'declined'])) {
            $subTab = 'received';
        }

        // Fetch received connection requests
        $receivedRequests = ConnectionRequest::where('receiver_id', $candidate->id)->get();
        $pendingRequests = $receivedRequests->where('status', 'pending');
        $acceptedRequests = $receivedRequests->where('status', 'accepted');
        $declinedRequests = $receivedRequests->where('status', 'declined');

        // Build list of received match profiles
        $receivedMatches = [];
        $targetRequests = match ($subTab) {
            'accepted' => $acceptedRequests,
            'declined' => $declinedRequests,
            default => $pendingRequests,
        };

        foreach ($targetRequests as $cr) {
            $sender = Candidate::with('photos')->find($cr->sender_id);
            if (! $sender) {
                continue;
            }

            $age = $sender->dob ? Carbon::parse($sender->dob)->age : 26;
            $targetGender = $sender->gender ?? 'Female';
            $genderDir = strtolower($targetGender) === 'female' ? 'female' : 'male';
            $profileCode = $sender->getDisplayCodeAttribute();

            // Image URL
            $photo = asset("img/{$genderDir}/correct1.png");
            if (! empty($sender->profile_picture)) {
                if (str_starts_with($sender->profile_picture, 'http')) {
                    $photo = $sender->profile_picture;
                } elseif (str_starts_with($sender->profile_picture, 'img/')) {
                    $photo = asset($sender->profile_picture);
                } else {
                    $photo = asset('storage/'.$sender->profile_picture);
                }
            }

            // Photo Gallery
            $allPhotos = [$photo];
            if ($sender->photos && $sender->photos->isNotEmpty()) {
                foreach ($sender->photos as $p) {
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

            // Compatibility Score
            $matchResult = $this->calculateMatchScore($candidate, $sender);
            $isAccepted = ($cr->status === 'accepted');

            // Full Details
            $fullDetails = [
                'mobile' => $sender->mobile ? ('+91 '.preg_replace('/(\d{5})(\d{5})/', '$1 $2', $sender->mobile)) : '+91 98201 49842',
                'raw_mobile' => $sender->mobile ? ltrim($sender->mobile, '0') : '9820149842',
                'email' => $sender->email ?: (strtolower($sender->first_name ?? 'candidate').'@gmail.com'),
                'full_address' => $sender->full_address ?: ($sender->city.', '.$sender->state),
                'police_st' => $sender->police_st ?: 'Local Station',
                'pincode' => $sender->pincode ?: '400001',
                'about_yourself' => $sender->about_yourself ?: 'I am a values-driven individual looking for a caring partner.',
                'mother_profession' => $sender->mother_profession ?: 'Homemaker',
                'father_profession' => $sender->father_profession ?: 'Businessman',
                'family_location' => $sender->family_location ?: ($sender->city.', '.$sender->state),
                'sisters_count' => $sender->sisters_count ?? '0',
                'brothers_count' => $sender->brothers_count ?? '1',
                'family_financial_status' => $sender->family_financial_status ?: 'Upper Middle Class',
                'gothra' => $sender->gothra ?: 'Kashyap',
                'manglik' => $sender->manglik ?: 'Non-Manglik',
                'time_of_birth' => $sender->time_of_birth ?: '08:30 AM',
                'city_of_birth' => $sender->city_of_birth ?: $sender->city,
                'blood_group' => $sender->blood_group ?: 'O+',
                'college_name' => $sender->college_name ?: 'University of Mumbai',
                'college_address' => $sender->college_address ?: $sender->city,
                'company_address' => $sender->company_address ?: ($sender->city.', '.$sender->state),
                'working_with' => $sender->working_with ?: 'Private Company',
                'hobbies' => is_array($sender->hobbies_interests) ? $sender->hobbies_interests : ['Travelling', 'Reading', 'Music', 'Fitness'],
            ];

            $receivedMatches[] = [
                'id' => $profileCode,
                'db_id' => $sender->id,
                'connection_id' => $cr->id,
                'first_name' => $sender->first_name ?? 'Candidate',
                'last_name' => $sender->last_name ?? '',
                'age' => $age,
                'height' => $sender->height ?? "5' 7\"",
                'religion' => $sender->religion ?? 'Hindu',
                'community' => $sender->community ?? 'General',
                'mother_tongue' => $sender->mother_tongue ?? 'Hindi',
                'highest_qualification' => $sender->highest_qualification ?? 'Graduate',
                'profession' => $sender->profession ?? 'Professional',
                'company_name' => $sender->company_name ?? 'Reputed Organization',
                'annual_income' => $sender->annual_income ?? '₹ 20 - 30 Lakh',
                'city' => $sender->city ?? 'Mumbai',
                'state' => $sender->state ?? 'Maharashtra',
                'diet' => $sender->diet ?? 'Vegetarian',
                'photo' => $photo,
                'photos' => $allPhotos,
                'match_score' => $matchResult['score'],
                'match_reasons' => array_slice($matchResult['reasons'], 0, 3),
                'badge' => $isAccepted ? 'Accepted Connection' : '📥 Received Interest',
                'verified' => (bool) $sender->selfie_verified,
                'received_ago' => $cr->created_at ? $cr->created_at->diffForHumans() : 'Recently',
                'status' => $cr->status,
                'is_accepted' => $isAccepted,
                'details' => $fullDetails,
            ];
        }

        $counts = [
            'pending' => $pendingRequests->count(),
            'accepted' => $acceptedRequests->count(),
            'declined' => $declinedRequests->count(),
            'total' => $receivedRequests->count(),
        ];

        return view('frontend.pages.inbox', compact(
            'candidate',
            'subTab',
            'receivedMatches',
            'counts'
        ));
    }

    /**
     * Calculate comprehensive data-wise match percentage
     */
    private function calculateMatchScore(Candidate $me, Candidate $other): array
    {
        $score = 50;
        $matchReasons = [];

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
        if (! empty($other->city) && (
            (! empty($me->city) && strcasecmp($me->city, $other->city) === 0) ||
            (! empty($me->pref_city) && strcasecmp($me->pref_city, $other->city) === 0)
        )) {
            $score += 12;
            $matchReasons[] = $other->city.' Resident';
        }

        return [
            'score' => min(98, $score + 15),
            'reasons' => ! empty($matchReasons) ? $matchReasons : ['High Compatibility Match', 'Verified Profile'],
        ];
    }
}
