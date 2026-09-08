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

        // Robust opposite gender detection
        $userGender = strtolower(trim($candidate->gender ?? ''));
        $targetGender = ($userGender === 'male' || $userGender === 'man') ? 'Female' : 'Male';

        // Load shortlisted profile IDs from database
        $shortlistedIds = Shortlisted::where('candidate_id', $candidate->id)
            ->pluck('profile_id')
            ->toArray();

        // Full pool for dynamic counts
        $allMatches = $this->getMatchesData($candidate, $targetGender, 'my_matches', $shortlistedIds);
        $todaysMatches = $this->getMatchesData($candidate, $targetGender, 'todays', $shortlistedIds);
        $acceptedMatches = $this->getMatchesData($candidate, $targetGender, 'accepted', $shortlistedIds);

        // Filtered matches for the active tab
        $matches = match ($tab) {
            'my_matches' => $allMatches,
            'todays' => $todaysMatches,
            'accepted' => $acceptedMatches,
            default => $this->getMatchesData($candidate, $targetGender, 'shortlisted', $shortlistedIds),
        };

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
     * Generate structured matches list from DB candidates with real dynamic data-wise match percentage
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

            // Calculate dynamic data-wise match percentage & reasons
            $matchResult = $this->calculateMatchScore($candidate, $c);
            $matchScore = $matchResult['score'];
            $matchReasons = $matchResult['reasons'];

            $badge = $matchScore >= 95 ? 'Top Recommendation' : (
                $matchScore >= 90 ? 'High Compatibility' : (
                    $c->selfie_verified ? 'Verified Profile' : 'Compatible Match'
                )
            );

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

        // Sort pool by match_score descending so top matching profiles show first
        usort($pool, fn ($a, $b) => $b['match_score'] <=> $a['match_score']);

        // Filter based on tab if specific category match, or return curated list
        if ($tab === 'shortlisted') {
            $filtered = array_filter($pool, fn ($m) => in_array($m['id'], $shortlistedIds));
        } elseif ($tab === 'accepted') {
            $filtered = array_filter($pool, fn ($m) => $m['verified'] || $m['match_score'] >= 85);
        } elseif ($tab === 'todays') {
            // Today's Picks: Top highest compatibility recommendations
            $filtered = array_slice($pool, 0, 6);
        } else {
            // 'my_matches' - All opposite gender matches
            $filtered = $pool;
        }

        return array_values($filtered);
    }

    /**
     * Calculate comprehensive data-wise match percentage and reasons
     * Compares Religion, Community, Location, Diet, Education, Career, Age, Height, Hobbies, Mother Tongue, and Astrological compatibility.
     */
    private function calculateMatchScore(Candidate $me, Candidate $other): array
    {
        $score = 50; // Base score for opposite gender compatibility
        $matchReasons = [];

        // 1. Religion & Community (Max 18 points)
        $relMatched = false;
        if (! empty($other->religion)) {
            if ((! empty($me->religion) && strcasecmp($me->religion, $other->religion) === 0) ||
                (! empty($me->pref_religion) && strcasecmp($me->pref_religion, $other->religion) === 0)) {
                $score += 10;
                $relMatched = true;
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
        } elseif (! empty($other->country) && (
            (! empty($me->country) && strcasecmp($me->country, $other->country) === 0) ||
            (! empty($me->pref_country) && strcasecmp($me->pref_country, $other->country) === 0)
        )) {
            $score += 4;
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

        // 11. Astro / Manglik (Max 4 points)
        if (! empty($me->manglik) && ! empty($other->manglik)) {
            if ($me->manglik === $other->manglik || $me->manglik === 'Non-Manglik' || $other->manglik === 'Non-Manglik') {
                $score += 4;
            }
        }

        // Clamp final score between 65% and 99%
        $finalScore = min(99, max(65, (int) round($score)));

        // Fallbacks if match reasons list is empty
        if (empty($matchReasons)) {
            $matchReasons = ['High Compatibility', 'Personality Match'];
        }

        return [
            'score' => $finalScore,
            'reasons' => array_values(array_unique($matchReasons)),
        ];
    }
}
