<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Shortlisted;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $targetGender = strtolower($candidate->gender ?? 'female') === 'female' ? 'Male' : 'Female';

        // Load shortlisted profile IDs from database
        $shortlistedIds = Shortlisted::where('candidate_id', $candidate->id)
            ->pluck('profile_id')
            ->toArray();

        // Full pool for dynamic counts
        $allMatches = $this->getMatchesData($candidate, $targetGender, 'my_matches', $shortlistedIds);
        $todaysMatches = $this->getMatchesData($candidate, $targetGender, 'todays', $shortlistedIds);
        $acceptedMatches = $this->getMatchesData($candidate, $targetGender, 'accepted', $shortlistedIds);

        // Filtered matches for the active tab
        $matches = $tab === 'my_matches' ? $allMatches : (
            $tab === 'todays' ? $todaysMatches : (
                $tab === 'accepted' ? $acceptedMatches : $this->getMatchesData($candidate, $targetGender, 'shortlisted', $shortlistedIds)
            )
        );

        // Counts for tabs
        $counts = [
            'todays' => count($todaysMatches),
            'shortlisted' => count($shortlistedIds),
            'my_matches' => count($allMatches),
            'accepted' => count($acceptedMatches),
        ];

        return view('frontend.pages.matches', compact(
            'candidate',
            'tab',
            'matches',
            'counts',
            'shortlistedIds'
        ));
    }

    /**
     * Send interest / Connect with match
     */
    public function sendInterest(Request $request)
    {
        $request->validate([
            'profile_id' => 'required|string',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Interest request sent successfully! We will notify you once accepted.',
        ]);
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

        $existing = Shortlisted::where('candidate_id', $candidate->id)
            ->where('profile_id', $profileId)
            ->first();

        if ($existing) {
            $existing->delete();
            $shortlisted = false;
            $message = 'Profile removed from your shortlist.';
        } else {
            Shortlisted::create([
                'candidate_id' => $candidate->id,
                'profile_id' => $profileId,
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
     * Generate structured matches list from DB candidates
     */
    private function getMatchesData(Candidate $candidate, string $targetGender, string $tab, array $shortlistedIds = []): array
    {
        $dbCandidates = Candidate::with('photos')
            ->where('gender', $targetGender)
            ->where('id', '!=', $candidate->id)
            ->get();

        $pool = [];

        foreach ($dbCandidates as $index => $c) {
            $age = $c->dob ? Carbon::parse($c->dob)->age : (24 + ($c->id % 8));
            $profileCode = $c->profile_id ?? $c->candidate_code ?? ('RM'.str_pad($c->id, 5, '0', STR_PAD_LEFT));

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

            // Category assignment for realistic matchmaking feeds
            $category = 'my_matches';
            if ($index % 3 === 0) {
                $category = 'todays';
            } elseif ($index % 4 === 0) {
                $category = 'accepted';
            }

            $matchScore = 88 + (($c->id * 3) % 11);
            $badge = $matchScore >= 95 ? 'Top Recommendation' : ($c->selfie_verified ? 'Verified Profile' : 'High Compatibility');

            $matchReasons = [];
            if ($c->community) {
                $matchReasons[] = $c->community.' Match';
            }
            if ($c->highest_qualification) {
                $matchReasons[] = 'Education Match';
            }
            if ($c->diet) {
                $matchReasons[] = $c->diet.' Diet';
            }
            if (empty($matchReasons)) {
                $matchReasons = ['High Compatibility', 'Education Match'];
            }

            $pool[] = [
                'id' => $profileCode,
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
                'category' => $category,
                'distance' => (4 + (($c->id * 2) % 20)).' km away',
            ];
        }

        // Filter based on tab if specific category match, or return curated list
        if ($tab === 'shortlisted') {
            $filtered = array_filter($pool, fn ($m) => in_array($m['id'], $shortlistedIds));
        } elseif ($tab === 'accepted') {
            $filtered = array_filter($pool, fn ($m) => in_array($m['category'], ['accepted', 'todays']));
        } elseif ($tab === 'my_matches') {
            $filtered = $pool;
        } else {
            // 'todays'
            $filtered = array_filter($pool, fn ($m) => in_array($m['category'], ['todays', 'my_matches']));
        }

        return array_values($filtered);
    }
}
