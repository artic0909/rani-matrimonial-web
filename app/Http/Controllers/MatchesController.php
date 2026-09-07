<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidate;
use App\Models\Shortlisted;

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
        if (!in_array($tab, ['todays', 'shortlisted', 'my_matches', 'near_me'])) {
            $tab = 'todays';
        }

        $targetGender = strtolower($candidate->gender ?? 'female') === 'female' ? 'Male' : 'Female';

        // Load shortlisted profile IDs from database
        $shortlistedIds = Shortlisted::where('candidate_id', $candidate->id)
            ->pluck('profile_id')
            ->toArray();

        // Sample / DB Matches List
        $matches = $this->getMatchesData($candidate, $targetGender, $tab, $shortlistedIds);

        // Counts for tabs
        $counts = [
            'todays' => 8,
            'shortlisted' => count($shortlistedIds),
            'my_matches' => 26,
            'near_me' => 11,
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
     * Generate structured matches list
     */
    private function getMatchesData(Candidate $candidate, string $targetGender, string $tab, array $shortlistedIds = []): array
    {
        $isFemaleTarget = strtolower($targetGender) === 'female';

        if ($isFemaleTarget) {
            $pool = [
                [
                    'id' => 'RM00101',
                    'first_name' => 'Aanya',
                    'last_name' => 'Sharma',
                    'age' => 25,
                    'height' => "5' 5\"",
                    'religion' => 'Hindu',
                    'community' => 'Brahmin',
                    'mother_tongue' => 'Hindi',
                    'highest_qualification' => 'B.Tech - Computer Science',
                    'profession' => 'Senior Software Engineer',
                    'company_name' => 'Google India',
                    'annual_income' => '₹ 25 - 35 Lakh',
                    'city' => 'Mumbai',
                    'state' => 'Maharashtra',
                    'diet' => 'Vegetarian',
                    'photo' => asset('img/female/correct1.png'),
                    'match_score' => 96,
                    'match_reasons' => ['Same Community', 'Education Match', 'Diet Match'],
                    'badge' => 'Top Recommendation',
                    'verified' => true,
                    'active_ago' => 'Active 2 hours ago',
                    'category' => 'todays',
                    'distance' => '8 km away',
                ],
                [
                    'id' => 'RM00102',
                    'first_name' => 'Dr. Riya',
                    'last_name' => 'Patel',
                    'age' => 26,
                    'height' => "5' 4\"",
                    'religion' => 'Hindu',
                    'community' => 'Gujarati',
                    'mother_tongue' => 'Gujarati',
                    'highest_qualification' => 'MBBS, MD (Medicine)',
                    'profession' => 'Doctor / Consultant',
                    'company_name' => 'Apollo Hospitals',
                    'annual_income' => '₹ 20 - 30 Lakh',
                    'city' => 'Ahmedabad',
                    'state' => 'Gujarat',
                    'diet' => 'Vegetarian',
                    'photo' => asset('img/female/correct2.png'),
                    'match_score' => 93,
                    'match_reasons' => ['High Compatibility', 'Professional Match'],
                    'badge' => 'Newly Joined',
                    'verified' => true,
                    'active_ago' => 'Online now',
                    'category' => 'new',
                    'distance' => '12 km away',
                ],
                [
                    'id' => 'RM00103',
                    'first_name' => 'Simran',
                    'last_name' => 'Kaur',
                    'age' => 24,
                    'height' => "5' 6\"",
                    'religion' => 'Sikh',
                    'community' => 'Khatri',
                    'mother_tongue' => 'Punjabi',
                    'highest_qualification' => 'MBA - Marketing & Finance',
                    'profession' => 'Brand Manager',
                    'company_name' => 'Hindustan Unilever',
                    'annual_income' => '₹ 18 - 25 Lakh',
                    'city' => 'Delhi',
                    'state' => 'Delhi NCR',
                    'diet' => 'Non-Vegetarian',
                    'photo' => asset('img/female/side.png'),
                    'match_score' => 89,
                    'match_reasons' => ['Lifestyle Match', 'Income Match'],
                    'badge' => 'Verified Profile',
                    'verified' => true,
                    'active_ago' => 'Active today',
                    'category' => 'my_matches',
                    'distance' => '22 km away',
                ],
                [
                    'id' => 'RM00104',
                    'first_name' => 'Ananya',
                    'last_name' => 'Deshmukh',
                    'age' => 25,
                    'height' => "5' 3\"",
                    'religion' => 'Hindu',
                    'community' => 'Maratha',
                    'mother_tongue' => 'Marathi',
                    'highest_qualification' => 'Chartered Accountant (CA)',
                    'profession' => 'Finance Analyst',
                    'company_name' => 'Deloitte',
                    'annual_income' => '₹ 22 - 28 Lakh',
                    'city' => 'Pune',
                    'state' => 'Maharashtra',
                    'diet' => 'Vegetarian',
                    'photo' => asset('img/female/stock.png'),
                    'match_score' => 91,
                    'match_reasons' => ['Nearby Location', 'Education Match'],
                    'badge' => 'Near You',
                    'verified' => true,
                    'active_ago' => 'Active 1 hour ago',
                    'category' => 'near_me',
                    'distance' => '5 km away',
                ],
                [
                    'id' => 'RM00105',
                    'first_name' => 'Kavya',
                    'last_name' => 'Nair',
                    'age' => 26,
                    'height' => "5' 5\"",
                    'religion' => 'Hindu',
                    'community' => 'Nair',
                    'mother_tongue' => 'Malayalam',
                    'highest_qualification' => 'M.S. Data Science',
                    'profession' => 'AI Research Engineer',
                    'company_name' => 'Microsoft',
                    'annual_income' => '₹ 30 - 45 Lakh',
                    'city' => 'Bengaluru',
                    'state' => 'Karnataka',
                    'diet' => 'Eggetarian',
                    'photo' => asset('img/female/group.png'),
                    'match_score' => 95,
                    'match_reasons' => ['Astro Match', 'Profession Match'],
                    'badge' => 'Premium Pick',
                    'verified' => true,
                    'active_ago' => 'Active 3 hours ago',
                    'category' => 'todays',
                    'distance' => '15 km away',
                ],
                [
                    'id' => 'RM00106',
                    'first_name' => 'Pooja',
                    'last_name' => 'Iyer',
                    'age' => 25,
                    'height' => "5' 4\"",
                    'religion' => 'Hindu',
                    'community' => 'Tamil Brahmin',
                    'mother_tongue' => 'Tamil',
                    'highest_qualification' => 'B.Arch - Architecture',
                    'profession' => 'Architectural Designer',
                    'company_name' => 'Hafeez Contractor',
                    'annual_income' => '₹ 15 - 20 Lakh',
                    'city' => 'Chennai',
                    'state' => 'Tamil Nadu',
                    'diet' => 'Vegetarian',
                    'photo' => asset('img/female/correct1.png'),
                    'match_score' => 88,
                    'match_reasons' => ['Community Match', 'Diet Match'],
                    'badge' => 'New Joiner',
                    'verified' => true,
                    'active_ago' => 'Registered yesterday',
                    'category' => 'new',
                    'distance' => '18 km away',
                ],
            ];
        } else {
            $pool = [
                [
                    'id' => 'RM00201',
                    'first_name' => 'Aarav',
                    'last_name' => 'Kapoor',
                    'age' => 28,
                    'height' => "5' 11\"",
                    'religion' => 'Hindu',
                    'community' => 'Punjabi Khatri',
                    'mother_tongue' => 'Hindi',
                    'highest_qualification' => 'B.Tech - IIT Bombay',
                    'profession' => 'Product Manager',
                    'company_name' => 'Amazon India',
                    'annual_income' => '₹ 35 - 50 Lakh',
                    'city' => 'Mumbai',
                    'state' => 'Maharashtra',
                    'diet' => 'Vegetarian',
                    'photo' => asset('img/male/correct1.png'),
                    'match_score' => 97,
                    'match_reasons' => ['Education Match', 'Diet Match', 'High Match Score'],
                    'badge' => 'Top Recommendation',
                    'verified' => true,
                    'active_ago' => 'Online now',
                    'category' => 'todays',
                    'distance' => '6 km away',
                ],
                [
                    'id' => 'RM00202',
                    'first_name' => 'Dr. Rohan',
                    'last_name' => 'Mehta',
                    'age' => 29,
                    'height' => "6' 0\"",
                    'religion' => 'Hindu',
                    'community' => 'Gujarati',
                    'mother_tongue' => 'Gujarati',
                    'highest_qualification' => 'MS - Orthopedic Surgeon',
                    'profession' => 'Surgeon & Consultant',
                    'company_name' => 'Lilavati Hospital',
                    'annual_income' => '₹ 40 - 60 Lakh',
                    'city' => 'Mumbai',
                    'state' => 'Maharashtra',
                    'diet' => 'Vegetarian',
                    'photo' => asset('img/male/correct2.png'),
                    'match_score' => 94,
                    'match_reasons' => ['Career Match', 'Location Match'],
                    'badge' => 'Newly Registered',
                    'verified' => true,
                    'active_ago' => 'Active 30 mins ago',
                    'category' => 'new',
                    'distance' => '9 km away',
                ],
                [
                    'id' => 'RM00203',
                    'first_name' => 'Kabir',
                    'last_name' => 'Singhania',
                    'age' => 27,
                    'height' => "5' 10\"",
                    'religion' => 'Hindu',
                    'community' => 'Marwari',
                    'mother_tongue' => 'Hindi',
                    'highest_qualification' => 'MBA - IIM Ahmedabad',
                    'profession' => 'Investment Banker',
                    'company_name' => 'Goldman Sachs',
                    'annual_income' => '₹ 45 - 65 Lakh',
                    'city' => 'Delhi',
                    'state' => 'Delhi NCR',
                    'diet' => 'Eggetarian',
                    'photo' => asset('img/male/side.png'),
                    'match_score' => 92,
                    'match_reasons' => ['Lifestyle Match', 'Income Match'],
                    'badge' => 'Verified Profile',
                    'verified' => true,
                    'active_ago' => 'Active 1 hour ago',
                    'category' => 'my_matches',
                    'distance' => '25 km away',
                ],
                [
                    'id' => 'RM00204',
                    'first_name' => 'Aditya',
                    'last_name' => 'Kulkarni',
                    'age' => 28,
                    'height' => "5' 9\"",
                    'religion' => 'Hindu',
                    'community' => 'Brahmin',
                    'mother_tongue' => 'Marathi',
                    'highest_qualification' => 'M.S. Computer Engineering',
                    'profession' => 'Lead Cloud Architect',
                    'company_name' => 'Oracle India',
                    'annual_income' => '₹ 30 - 40 Lakh',
                    'city' => 'Pune',
                    'state' => 'Maharashtra',
                    'diet' => 'Vegetarian',
                    'photo' => asset('img/male/stock.png'),
                    'match_score' => 90,
                    'match_reasons' => ['Nearby Location', 'Education Match'],
                    'badge' => 'Near You',
                    'verified' => true,
                    'active_ago' => 'Active today',
                    'category' => 'near_me',
                    'distance' => '4 km away',
                ],
                [
                    'id' => 'RM00205',
                    'first_name' => 'Vikram',
                    'last_name' => 'Reddy',
                    'age' => 29,
                    'height' => "6' 1\"",
                    'religion' => 'Hindu',
                    'community' => 'Reddy',
                    'mother_tongue' => 'Telugu',
                    'highest_qualification' => 'B.Tech + MS (USA)',
                    'profession' => 'Engineering Manager',
                    'company_name' => 'Adobe',
                    'annual_income' => '₹ 50 - 70 Lakh',
                    'city' => 'Bengaluru',
                    'state' => 'Karnataka',
                    'diet' => 'Non-Vegetarian',
                    'photo' => asset('img/male/group.png'),
                    'match_score' => 95,
                    'match_reasons' => ['Partner Preference Match', 'Astro Compatibility'],
                    'badge' => 'Premium Match',
                    'verified' => true,
                    'active_ago' => 'Active 2 hours ago',
                    'category' => 'todays',
                    'distance' => '14 km away',
                ],
            ];
        }

        // Filter based on tab if specific category match, or return curated list
        if ($tab === 'shortlisted') {
            $filtered = array_filter($pool, fn($m) => in_array($m['id'], $shortlistedIds));
        } elseif ($tab === 'near_me') {
            $filtered = array_filter($pool, fn($m) => in_array($m['category'], ['near_me', 'todays']));
        } elseif ($tab === 'my_matches') {
            $filtered = $pool;
        } else {
            // 'todays'
            $filtered = array_filter($pool, fn($m) => in_array($m['category'], ['todays', 'my_matches']));
        }

        return array_values($filtered);
    }
}
