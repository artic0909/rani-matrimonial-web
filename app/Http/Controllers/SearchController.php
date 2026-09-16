<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\City;
use App\Models\Community;
use App\Models\ConnectionRequest;
use App\Models\Country;
use App\Models\Diet;
use App\Models\Height;
use App\Models\Hobby;
use App\Models\Income;
use App\Models\MaritalStatus;
use App\Models\Religion;
use App\Models\Shortlisted;
use App\Models\State;
use App\Models\WorkingWith;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    /**
     * Display candidate search page
     */
    public function index(Request $request)
    {
        $candidate = Auth::user();

        // Load master data for all filter dropdowns
        $religions = Religion::with('communities')->get();
        $countries = Country::with(['states.cities'])->get();
        $maritalStatuses = MaritalStatus::all();
        $heights = Height::all();
        $diets = Diet::all();
        $incomes = Income::all();
        $workingWiths = WorkingWith::all();
        $hobbies = Hobby::all();

        // Additional candidate table field lists
        $motherTongues = [
            'Bengali', 'Hindi', 'Telugu', 'Marathi', 'Tamil', 'Gujarati', 'Urdu',
            'Kannada', 'Odia', 'Malayalam', 'Punjabi', 'Assamese', 'Maithili',
            'Marwari', 'Sindhi', 'Konkani', 'Kashmiri', 'Nepali', 'English'
        ];
        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $familyFinancialStatuses = ['Rich / Affluent', 'Upper Middle Class', 'Middle Class', 'Modest'];
        $residencyStatuses = ['Citizen', 'Permanent Resident', 'Work Permit', 'Student Visa', 'Temporary Visa'];
        $profileFors = ['Self', 'Son', 'Daughter', 'Brother', 'Sister', 'Friend', 'Relative'];

        // Default search gender filter
        $defaultGender = 'all';
        if ($candidate && ! empty($candidate->gender)) {
            $userGender = strtolower(trim($candidate->gender));
            $defaultGender = ($userGender === 'male' || $userGender === 'man') ? 'Female' : 'Male';
        }

        return view('frontend.pages.search', compact(
            'candidate',
            'religions',
            'countries',
            'maritalStatuses',
            'heights',
            'diets',
            'incomes',
            'workingWiths',
            'hobbies',
            'motherTongues',
            'bloodGroups',
            'familyFinancialStatuses',
            'residencyStatuses',
            'profileFors',
            'defaultGender'
        ));
    }

    /**
     * Parse human readable height string to total inches
     */
    public static function parseHeightToInches(?string $str): ?int
    {
        if (empty($str)) {
            return null;
        }

        if (preg_match('/(\d+)\s*[\'ft\.]+\s*(\d+)?/i', $str, $m)) {
            $feet = (int) $m[1];
            $inches = isset($m[2]) ? (int) $m[2] : 0;

            return ($feet * 12) + $inches;
        }

        if (preg_match('/(\d+)\s*cm/i', $str, $m)) {
            return (int) round((float) $m[1] / 2.54);
        }

        return null;
    }

    /**
     * Parse annual income string into [minLakhs, maxLakhs]
     */
    public static function parseIncomeRange(?string $str): array
    {
        if (empty($str) || strtolower($str) === 'all') {
            return [0, 99999];
        }

        if (stripos($str, 'crore') !== false) {
            if (preg_match('/(\d+(?:\.\d+)?)\s*crore/i', $str, $m)) {
                $val = (float) $m[1] * 100;

                return [$val, 99999];
            }

            return [100, 99999];
        }

        preg_match_all('/(\d+(?:\.\d+)?)/', $str, $m);
        if (! empty($m[1])) {
            $nums = array_map('floatval', $m[1]);
            if (count($nums) >= 2) {
                return [min($nums), max($nums)];
            }

            return [$nums[0], $nums[0]];
        }

        return [0, 99999];
    }

    /**
     * AJAX Search / Filter candidates dynamically across all fields
     */
    public function filter(Request $request)
    {
        $currentCandidate = Auth::user();

        $query = Candidate::with(['photos', 'bluetick']);

        // Exclude logged in user
        if ($currentCandidate) {
            $query->where('id', '!=', $currentCandidate->id);
        }

        // 1. Keyword / Profile ID / Name
        $keyword = trim($request->input('keyword', ''));
        if (! empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('candidate_code', 'LIKE', "%{$keyword}%")
                    ->orWhere('profile_id', 'LIKE', "%{$keyword}%")
                    ->orWhere('first_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('last_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('profession', 'LIKE', "%{$keyword}%")
                    ->orWhere('designation', 'LIKE', "%{$keyword}%")
                    ->orWhere('company_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('city', 'LIKE', "%{$keyword}%")
                    ->orWhere('state', 'LIKE', "%{$keyword}%")
                    ->orWhere('highest_qualification', 'LIKE', "%{$keyword}%")
                    ->orWhere('about_yourself', 'LIKE', "%{$keyword}%");
            });
        }

        // 2. Gender Filter
        $gender = trim($request->input('gender', 'all'));
        if (! empty($gender) && strtolower($gender) !== 'all') {
            if (strtolower($gender) === 'female' || strtolower($gender) === 'bride') {
                $query->where(function ($q) {
                    $q->where('gender', 'Female')
                        ->orWhere('gender', 'female')
                        ->orWhere('gender', 'Woman');
                });
            } elseif (strtolower($gender) === 'male' || strtolower($gender) === 'groom') {
                $query->where(function ($q) {
                    $q->where('gender', 'Male')
                        ->orWhere('gender', 'male')
                        ->orWhere('gender', 'Man');
                });
            } else {
                $query->where('gender', $gender);
            }
        }

        // 3. Age Range Filter (Calculated via dob)
        $ageMin = $request->input('age_min');
        $ageMax = $request->input('age_max');
        if (! empty($ageMin) && is_numeric($ageMin) && (int) $ageMin > 0) {
            $maxDob = Carbon::now()->subYears((int) $ageMin)->format('Y-m-d');
            $query->where(function ($q) use ($maxDob) {
                $q->whereDate('dob', '<=', $maxDob)->orWhereNull('dob');
            });
        }
        if (! empty($ageMax) && is_numeric($ageMax) && (int) $ageMax < 100) {
            $minDob = Carbon::now()->subYears((int) $ageMax + 1)->format('Y-m-d');
            $query->where(function ($q) use ($minDob) {
                $q->whereDate('dob', '>=', $minDob)->orWhereNull('dob');
            });
        }

        // 4. Profile Created For Filter
        $profileFor = trim($request->input('profile_for', 'all'));
        if (! empty($profileFor) && strtolower($profileFor) !== 'all') {
            $query->where('profile_for', 'LIKE', "%{$profileFor}%");
        }

        // 5. Marital Status Filter
        $maritalStatus = trim($request->input('marital_status', 'all'));
        if (! empty($maritalStatus) && strtolower($maritalStatus) !== 'all') {
            $query->where(function ($q) use ($maritalStatus) {
                if ($maritalStatus === 'Never Married') {
                    $q->where('marital_status', 'LIKE', '%Never Married%')
                        ->orWhere('marital_status', 'LIKE', '%Single%')
                        ->orWhere('marital_status', 'LIKE', '%Unmarried%');
                } else {
                    $q->where('marital_status', 'LIKE', "%{$maritalStatus}%");
                }
            });
        }

        // 6. Religion Filter
        $religion = trim($request->input('religion', 'all'));
        if (! empty($religion) && strtolower($religion) !== 'all') {
            $query->where('religion', 'LIKE', "%{$religion}%");
        }

        // 7. Community / Caste Filter
        $community = trim($request->input('community', 'all'));
        if (! empty($community) && strtolower($community) !== 'all') {
            $query->where(function ($q) use ($community) {
                $q->where('community', 'LIKE', "%{$community}%")
                    ->orWhere('sub_community', 'LIKE', "%{$community}%");
            });
        }

        // 8. Sub Community Filter
        $subCommunity = trim($request->input('sub_community', 'all'));
        if (! empty($subCommunity) && strtolower($subCommunity) !== 'all') {
            $query->where('sub_community', 'LIKE', "%{$subCommunity}%");
        }

        // 9. Mother Tongue Filter
        $motherTongue = trim($request->input('mother_tongue', 'all'));
        if (! empty($motherTongue) && strtolower($motherTongue) !== 'all') {
            $query->where('mother_tongue', 'LIKE', "%{$motherTongue}%");
        }

        // 10. Gothra Filter
        $gothra = trim($request->input('gothra', ''));
        if (! empty($gothra)) {
            $query->where('gothra', 'LIKE', "%{$gothra}%");
        }

        // 11. Location Filters: Country, State, City
        $country = trim($request->input('country', 'all'));
        if (! empty($country) && strtolower($country) !== 'all') {
            $query->where('country', 'LIKE', "%{$country}%");
        }

        $state = trim($request->input('state', 'all'));
        if (! empty($state) && strtolower($state) !== 'all') {
            $query->where('state', 'LIKE', "%{$state}%");
        }

        $city = trim($request->input('city', 'all'));
        if (! empty($city) && strtolower($city) !== 'all') {
            $query->where('city', 'LIKE', "%{$city}%");
        }

        // 12. Residency Status / Living In / Grew Up In
        $residencyStatus = trim($request->input('residency_status', 'all'));
        if (! empty($residencyStatus) && strtolower($residencyStatus) !== 'all') {
            $query->where(function ($q) use ($residencyStatus) {
                $q->where('residency_status', 'LIKE', "%{$residencyStatus}%")
                    ->orWhere('living_in', 'LIKE', "%{$residencyStatus}%");
            });
        }

        $grewUpIn = trim($request->input('grew_up_in', ''));
        if (! empty($grewUpIn)) {
            $query->where('grew_up_in', 'LIKE', "%{$grewUpIn}%");
        }

        // 13. Diet Filter
        $diet = trim($request->input('diet', 'all'));
        if (! empty($diet) && strtolower($diet) !== 'all') {
            $query->where(function ($q) use ($diet) {
                if ($diet === 'Vegetarian') {
                    $q->where('diet', 'LIKE', '%Vegetarian%')
                        ->orWhere('diet', 'LIKE', '%Veg%')
                        ->orWhere('diet', 'LIKE', '%Jain%')
                        ->orWhere('diet', 'LIKE', '%Vegan%');
                } elseif ($diet === 'Non-Vegetarian') {
                    $q->where('diet', 'LIKE', '%Non-Vegetarian%')
                        ->orWhere('diet', 'LIKE', '%Non-Veg%')
                        ->orWhere('diet', 'LIKE', '%Occasionally Non-Veg%');
                } else {
                    $q->where('diet', 'LIKE', "%{$diet}%");
                }
            });
        }

        // 14. Education / Highest Qualification Filter
        $qualification = trim($request->input('highest_qualification', 'all'));
        if (! empty($qualification) && strtolower($qualification) !== 'all') {
            $query->where(function ($q) use ($qualification) {
                if ($qualification === 'Masters') {
                    $q->where('highest_qualification', 'LIKE', '%MBA%')
                        ->orWhere('highest_qualification', 'LIKE', '%MS%')
                        ->orWhere('highest_qualification', 'LIKE', '%M.S.%')
                        ->orWhere('highest_qualification', 'LIKE', '%M.A.%')
                        ->orWhere('highest_qualification', 'LIKE', '%M.Sc%')
                        ->orWhere('highest_qualification', 'LIKE', '%Master%')
                        ->orWhere('highest_qualification', 'LIKE', '%MD%')
                        ->orWhere('highest_qualification', 'LIKE', '%CA%')
                        ->orWhere('highest_qualification', 'LIKE', '%CS%')
                        ->orWhere('highest_qualification', 'LIKE', '%PGDM%')
                        ->orWhere('highest_qualification', 'LIKE', '%Post Graduate%');
                } elseif ($qualification === 'Doctorate') {
                    $q->where('highest_qualification', 'LIKE', '%Doctorate%')
                        ->orWhere('highest_qualification', 'LIKE', '%PhD%')
                        ->orWhere('highest_qualification', 'LIKE', '%Ph.D%');
                } elseif ($qualification === 'Bachelors') {
                    $q->where('highest_qualification', 'LIKE', '%Bachelors%')
                        ->orWhere('highest_qualification', 'LIKE', '%B.Tech%')
                        ->orWhere('highest_qualification', 'LIKE', '%B.E.%')
                        ->orWhere('highest_qualification', 'LIKE', '%B.Arch%')
                        ->orWhere('highest_qualification', 'LIKE', '%Graduate%')
                        ->orWhere('highest_qualification', 'LIKE', '%B.Sc%')
                        ->orWhere('highest_qualification', 'LIKE', '%B.Com%')
                        ->orWhere('highest_qualification', 'LIKE', '%B.A.%')
                        ->orWhere('highest_qualification', 'LIKE', '%MBBS%')
                        ->orWhere('highest_qualification', 'LIKE', '%LLB%')
                        ->orWhere('highest_qualification', 'LIKE', '%BBA%')
                        ->orWhere('highest_qualification', 'LIKE', '%BCA%');
                } elseif ($qualification === 'B.Tech') {
                    $q->where('highest_qualification', 'LIKE', '%B.Tech%')
                        ->orWhere('highest_qualification', 'LIKE', '%B.E.%')
                        ->orWhere('highest_qualification', 'LIKE', '%Engineering%')
                        ->orWhere('highest_qualification', 'LIKE', '%Computer%');
                } elseif ($qualification === 'MBA') {
                    $q->where('highest_qualification', 'LIKE', '%MBA%')
                        ->orWhere('highest_qualification', 'LIKE', '%PGDM%')
                        ->orWhere('highest_qualification', 'LIKE', '%Management%');
                } elseif ($qualification === 'MBBS') {
                    $q->where('highest_qualification', 'LIKE', '%MBBS%')
                        ->orWhere('highest_qualification', 'LIKE', '%MD%')
                        ->orWhere('highest_qualification', 'LIKE', '%Surgeon%')
                        ->orWhere('highest_qualification', 'LIKE', '%Medical%')
                        ->orWhere('highest_qualification', 'LIKE', '%Medicine%');
                } elseif ($qualification === 'CA') {
                    $q->where('highest_qualification', 'LIKE', '%Chartered Accountant%')
                        ->orWhere('highest_qualification', 'LIKE', '%CA%')
                        ->orWhere('highest_qualification', 'LIKE', '%CS%')
                        ->orWhere('highest_qualification', 'LIKE', '%Finance%');
                } else {
                    $q->where('highest_qualification', 'LIKE', "%{$qualification}%");
                }
            });
        }

        // 15. Working With / Sector Filter
        $workingWith = trim($request->input('working_with', 'all'));
        if (! empty($workingWith) && strtolower($workingWith) !== 'all') {
            $query->where(function ($q) use ($workingWith) {
                if (stripos($workingWith, 'Private') !== false) {
                    $q->where('working_with', 'LIKE', '%Private%')
                        ->orWhere('working_with', 'LIKE', '%MNC%')
                        ->orWhere('working_with', 'LIKE', '%Corporate%')
                        ->orWhere('working_with', 'LIKE', '%Firm%')
                        ->orWhere('working_with', 'LIKE', '%FMCG%')
                        ->orWhere('working_with', 'LIKE', '%Audit%');
                } elseif (stripos($workingWith, 'Government') !== false || stripos($workingWith, 'Public') !== false) {
                    $q->where('working_with', 'LIKE', '%Government%')
                        ->orWhere('working_with', 'LIKE', '%Public%')
                        ->orWhere('working_with', 'LIKE', '%Govt%')
                        ->orWhere('working_with', 'LIKE', '%PSU%')
                        ->orWhere('working_with', 'LIKE', '%Civil%')
                        ->orWhere('working_with', 'LIKE', '%Defense%');
                } elseif (stripos($workingWith, 'Business') !== false || stripos($workingWith, 'Self') !== false) {
                    $q->where('working_with', 'LIKE', '%Business%')
                        ->orWhere('working_with', 'LIKE', '%Self%')
                        ->orWhere('working_with', 'LIKE', '%Partner%')
                        ->orWhere('working_with', 'LIKE', '%Founder%')
                        ->orWhere('working_with', 'LIKE', '%Startup%')
                        ->orWhere('working_with', 'LIKE', '%Practice%')
                        ->orWhere('working_with', 'LIKE', '%Clinic%');
                } else {
                    $q->where('working_with', 'LIKE', "%{$workingWith}%");
                }
            });
        }

        // 16. Profession Filter
        $profession = trim($request->input('profession', 'all'));
        if (! empty($profession) && strtolower($profession) !== 'all') {
            $query->where(function ($q) use ($profession) {
                $q->where('profession', 'LIKE', "%{$profession}%")
                    ->orWhere('designation', 'LIKE', "%{$profession}%");
            });
        }

        // 17. Manglik / Astro Filter
        $manglik = trim($request->input('manglik', 'all'));
        if (! empty($manglik) && strtolower($manglik) !== 'all') {
            $query->where(function ($q) use ($manglik) {
                if ($manglik === 'Non-Manglik') {
                    $q->where('manglik', 'LIKE', '%Non-Manglik%')
                        ->orWhere('manglik', 'LIKE', '%Non Manglik%')
                        ->orWhere('manglik', 'LIKE', '%No%')
                        ->orWhere('manglik', 'LIKE', "%Don't Know%")
                        ->orWhereNull('manglik');
                } elseif ($manglik === 'Manglik') {
                    $q->where('manglik', 'LIKE', '%Manglik%')
                        ->orWhere('manglik', 'LIKE', '%Yes%')
                        ->orWhere('manglik', 'LIKE', '%Anshik%');
                } else {
                    $q->where('manglik', 'LIKE', "%{$manglik}%");
                }
            });
        }

        // 18. Blood Group Filter
        $bloodGroup = trim($request->input('blood_group', 'all'));
        if (! empty($bloodGroup) && strtolower($bloodGroup) !== 'all') {
            $query->where('blood_group', $bloodGroup);
        }

        // 19. Disability / Health Info Filter
        $disability = trim($request->input('disability', 'all'));
        if (! empty($disability) && strtolower($disability) !== 'all') {
            if ($disability === 'None') {
                $query->where(function ($q) {
                    $q->where('disability', 'None')
                        ->orWhere('disability', 'No')
                        ->orWhereNull('disability')
                        ->orWhere('disability', '');
                });
            } else {
                $query->where('disability', 'LIKE', "%{$disability}%");
            }
        }

        // 20. Family Financial Status Filter
        $familyStatus = trim($request->input('family_financial_status', 'all'));
        if (! empty($familyStatus) && strtolower($familyStatus) !== 'all') {
            $query->where('family_financial_status', 'LIKE', "%{$familyStatus}%");
        }

        // 21. Father's / Mother's Profession
        $fatherProfession = trim($request->input('father_profession', 'all'));
        if (! empty($fatherProfession) && strtolower($fatherProfession) !== 'all') {
            $query->where('father_profession', 'LIKE', "%{$fatherProfession}%");
        }

        $motherProfession = trim($request->input('mother_profession', 'all'));
        if (! empty($motherProfession) && strtolower($motherProfession) !== 'all') {
            $query->where('mother_profession', 'LIKE', "%{$motherProfession}%");
        }

        // 22. Hobbies / Interests Filter
        $hobbies = trim($request->input('hobbies_interests', 'all'));
        if (! empty($hobbies) && strtolower($hobbies) !== 'all') {
            $query->where('hobbies_interests', 'LIKE', "%{$hobbies}%");
        }

        // 23. Photo Available Only Filter
        $hasPhoto = $request->boolean('has_photo');
        if ($hasPhoto) {
            $query->where(function ($q) {
                $q->whereNotNull('profile_picture')
                    ->where('profile_picture', '!=', '')
                    ->orWhereHas('photos');
            });
        }

        // 24. Verified / Blue Tick Only Filter
        $verifiedOnly = $request->boolean('verified_only');
        if ($verifiedOnly) {
            $query->whereHas('bluetick', function ($q) {
                $q->where('is_accept', 1);
            });
        }

        // Sort order
        $sortBy = $request->input('sort_by', 'latest');
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('id', 'asc');
                break;
            case 'age_asc':
                $query->orderByRaw('dob DESC');
                break;
            case 'age_desc':
                $query->orderByRaw('dob ASC');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $allCandidates = $query->limit(200)->get();

        // 25. Smart Height Filter (Inches comparison min & max)
        $heightMin = trim($request->input('height_min', 'all'));
        $heightMax = trim($request->input('height_max', 'all'));
        $minInches = (! empty($heightMin) && strtolower($heightMin) !== 'all') ? self::parseHeightToInches($heightMin) : null;
        $maxInches = (! empty($heightMax) && strtolower($heightMax) !== 'all') ? self::parseHeightToInches($heightMax) : null;

        if (($minInches !== null && $minInches > 0) || ($maxInches !== null && $maxInches > 0)) {
            $allCandidates = $allCandidates->filter(function ($c) use ($minInches, $maxInches) {
                $candInches = SearchController::parseHeightToInches($c->height);
                if ($candInches === null) {
                    return true;
                }
                if ($minInches !== null && $candInches < $minInches) {
                    return false;
                }
                if ($maxInches !== null && $candInches > $maxInches) {
                    return false;
                }

                return true;
            });
        }

        // 16. Smart Annual Income Filter (Overlapping range comparison)
        $annualIncome = trim($request->input('annual_income', 'all'));
        if (! empty($annualIncome) && strtolower($annualIncome) !== 'all') {
            $filterRange = self::parseIncomeRange($annualIncome);
            $filterMin = $filterRange[0];
            $filterMax = $filterRange[1];

            $allCandidates = $allCandidates->filter(function ($c) use ($filterMin, $filterMax) {
                $candRange = SearchController::parseIncomeRange($c->annual_income);
                $candMin = $candRange[0];
                $candMax = $candRange[1];

                // Check range overlap: max(candMin, filterMin) <= min(candMax, filterMax)
                return max($candMin, $filterMin) <= min($candMax, $filterMax);
            });
        }

        // Shortlisted IDs & Connection Requests for authenticated user
        $shortlistedCodes = [];
        $sentRequestMap = [];
        $receivedRequestMap = [];
        $acceptedMap = [];

        if ($currentCandidate) {
            $shortlistedCodes = Shortlisted::where('candidate_id', $currentCandidate->id)
                ->pluck('profile_id')
                ->map(fn ($v) => (string) $v)
                ->toArray();

            $connections = ConnectionRequest::where(function ($q) use ($currentCandidate) {
                $q->where('sender_id', $currentCandidate->id)
                    ->orWhere('receiver_id', $currentCandidate->id);
            })->get();

            foreach ($connections as $conn) {
                $otherId = ($conn->sender_id === $currentCandidate->id) ? $conn->receiver_id : $conn->sender_id;
                if ($conn->status === 'accepted') {
                    $acceptedMap[$otherId] = true;
                } elseif ($conn->status === 'pending') {
                    if ($conn->sender_id === $currentCandidate->id) {
                        $sentRequestMap[$otherId] = true;
                    } else {
                        $receivedRequestMap[$otherId] = true;
                    }
                }
            }
        }

        $matchesController = new MatchesController;

        $formatted = $allCandidates->values()->map(function ($c) use ($currentCandidate, $shortlistedCodes, $sentRequestMap, $receivedRequestMap, $acceptedMap, $matchesController) {
            $age = $c->dob ? Carbon::parse($c->dob)->age : 26;

            // Photos
            $targetGender = $c->gender ?? 'Female';
            $genderDir = strtolower($targetGender) === 'female' ? 'female' : 'male';
            $photo = asset("img/{$genderDir}/correct1.png");
            if (! empty($c->profile_picture)) {
                if (str_starts_with($c->profile_picture, 'http')) {
                    $photo = $c->profile_picture;
                } elseif (str_starts_with($c->profile_picture, 'img/')) {
                    $photo = asset($c->profile_picture);
                } else {
                    $photo = asset('storage/'.$c->profile_picture);
                }
            }

            $allPhotos = [$photo];
            if ($c->photos && $c->photos->isNotEmpty()) {
                foreach ($c->photos as $p) {
                    $pUrl = $p->photo_path;
                    $fullUrl = str_starts_with($pUrl, 'http') ? $pUrl : (str_starts_with($pUrl, 'img/') ? asset($pUrl) : asset('storage/'.$pUrl));
                    if (! in_array($fullUrl, $allPhotos)) {
                        $allPhotos[] = $fullUrl;
                    }
                }
            }

            // Match Score
            $matchScore = 85;
            $matchReasons = ['High Compatibility', 'Personality Match'];
            if ($currentCandidate) {
                $scoreResult = $matchesController->calculateMatchScore($currentCandidate, $c);
                $matchScore = $scoreResult['score'];
                $matchReasons = $scoreResult['reasons'];
            }

            $isShortlisted = in_array((string) $c->id, $shortlistedCodes) ||
                             in_array($c->getDisplayCodeAttribute(), $shortlistedCodes) ||
                             in_array($c->candidate_code ?? '', $shortlistedCodes) ||
                             in_array($c->profile_id ?? '', $shortlistedCodes);

            $isAccepted = isset($acceptedMap[$c->id]);
            $isSentByMe = isset($sentRequestMap[$c->id]);
            $isReceivedByMe = isset($receivedRequestMap[$c->id]);

            $requestType = 'none';
            if ($isAccepted) {
                $requestType = 'accepted';
            } elseif ($isSentByMe) {
                $requestType = 'sent';
            } elseif ($isReceivedByMe) {
                $requestType = 'received';
            }

            return [
                'id' => $c->getDisplayCodeAttribute(),
                'numeric_id' => $c->id,
                'first_name' => $c->first_name ?: 'Member',
                'last_name' => $c->last_name ?: '',
                'age' => $age,
                'gender' => $c->gender ?: 'Not Specified',
                'height' => $c->height ?: "5' 5\"",
                'religion' => $c->religion ?: 'Not Specified',
                'community' => $c->community ?: 'All Communities',
                'mother_tongue' => $c->mother_tongue ?: ($c->community ?: 'Hindi'),
                'marital_status' => $c->marital_status ?: 'Never Married',
                'highest_qualification' => $c->highest_qualification ?: 'Graduate',
                'profession' => $c->profession ?: ($c->designation ?: 'Professional'),
                'working_with' => $c->working_with ?: 'Private Sector',
                'company_name' => $c->company_name ?: 'Reputed Company',
                'annual_income' => $c->annual_income ?: 'Not Disclosed',
                'diet' => $c->diet ?: 'Not Specified',
                'manglik' => $c->manglik ?: 'Non-Manglik',
                'city' => $c->city ?: 'City',
                'state' => $c->state ?: 'State',
                'country' => $c->country ?: 'India',
                'photo' => $photo,
                'photos' => $allPhotos,
                'verified' => (bool) ($c->bluetick && (int) $c->bluetick->is_accept === 1),
                'match_score' => $matchScore,
                'match_reasons' => $matchReasons,
                'is_shortlisted' => $isShortlisted,
                'is_accepted' => $isAccepted,
                'request_type' => $requestType,
                'token_url' => route('matches.view-profile', ['id' => MatchesController::generateProfileToken($c)]),
            ];
        });

        return response()->json([
            'success' => true,
            'count' => $formatted->count(),
            'candidates' => $formatted,
        ]);
    }
}
