<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MatchesController;
use App\Mail\NewCandidateRegistrationAdminMail;
use App\Models\Bluetick;
use App\Models\Branch;
use App\Models\Candidate;
use App\Models\CandidatePhoto;
use App\Models\ConnectionRequest;
use App\Models\Country;
use App\Models\Diet;
use App\Models\Height;
use App\Models\Hobby;
use App\Models\Income;
use App\Models\MaritalStatus;
use App\Models\Notification;
use App\Models\Referral;
use App\Models\Religion;
use App\Models\Shortlisted;
use App\Models\Wallet;
use App\Models\WhatsAppChatRequest;
use App\Models\WorkingWith;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Twilio\Rest\Client;

class AuthController extends Controller
{
    /**
     * Helper to build absolute URL for any asset or storage path.
     */
    protected function formatUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'data:image')) {
            return $path;
        }

        if (str_starts_with($path, 'storage/')) {
            return url($path);
        }

        if (str_starts_with($path, 'img/') || str_starts_with($path, 'logo.png')) {
            return url($path);
        }

        return url('storage/' . ltrim($path, '/'));
    }

    /**
     * Format a Candidate instance into a comprehensive array for Mobile API responses.
     */
    protected function formatCandidate(Candidate $candidate): array
    {
        $wallet = $candidate->getOrCreateWallet();

        $photos = $candidate->photos ? $candidate->photos->map(function ($photo) {
            return [
                'id' => $photo->id,
                'url' => $this->formatUrl($photo->photo_path),
                'is_profile_picture' => (bool) $photo->is_profile_picture,
                'created_at' => $photo->created_at ? $photo->created_at->diffForHumans() : '',
            ];
        }) : [];

        $age = null;
        if ($candidate->dob) {
            try {
                $dob = new \DateTime($candidate->dob);
                $now = new \DateTime;
                $age = $now->diff($dob)->y;
            } catch (\Exception $e) {
                // Ignore parse errors
            }
        }

        return [
            'id' => $candidate->id,
            'candidate_code' => $candidate->getDisplayCodeAttribute(),
            'profile_id' => $candidate->profile_id,
            'mobile' => $candidate->mobile,
            'email' => $candidate->email,
            'profile_for' => $candidate->profile_for,
            'gender' => $candidate->gender,
            'first_name' => $candidate->first_name,
            'middle_name' => $candidate->middle_name,
            'last_name' => $candidate->last_name,
            'full_name' => trim("{$candidate->first_name} {$candidate->middle_name} {$candidate->last_name}"),
            'dob' => $candidate->dob,
            'age' => $age,
            'avatar_url' => $this->formatUrl($candidate->avatar_url),
            'profile_picture' => $candidate->profile_picture,
            'profile_picture_url' => $this->formatUrl($candidate->profile_picture),
            'selfie_verified' => (bool) $candidate->selfie_verified,
            'is_bluetick_verified' => (bool) $candidate->is_bluetick_verified,
            'about_yourself' => $candidate->about_yourself,

            // Religion & Community
            'religion' => $candidate->religion,
            'community' => $candidate->community,
            'sub_community' => $candidate->sub_community,
            'gothra' => $candidate->gothra,
            'mother_tongue' => $candidate->mother_tongue,

            // Location
            'country' => $candidate->country,
            'state' => $candidate->state,
            'city' => $candidate->city,
            'living_in' => $candidate->living_in,
            'police_st' => $candidate->police_st,
            'pincode' => $candidate->pincode,
            'zip_code' => $candidate->zip_code,
            'residency_status' => $candidate->residency_status,
            'full_address' => $candidate->full_address,

            // Basics & Lifestyle
            'marital_status' => $candidate->marital_status,
            'height' => $candidate->height,
            'diet' => $candidate->diet,
            'blood_group' => $candidate->blood_group,
            'health_info' => $candidate->health_info,
            'grew_up_in' => $candidate->grew_up_in,
            'disability' => $candidate->disability,

            // Education & Career
            'highest_qualification' => $candidate->highest_qualification,
            'college_name' => $candidate->college_name,
            'college_address' => $candidate->college_address,
            'working_with' => $candidate->working_with,
            'profession' => $candidate->profession,
            'designation' => $candidate->designation,
            'company_name' => $candidate->company_name,
            'company_address' => $candidate->company_address,
            'annual_income' => $candidate->annual_income,
            'income_type' => $candidate->income_type,

            // Astro Details
            'manglik' => $candidate->manglik,
            'time_of_birth' => $candidate->time_of_birth,
            'city_of_birth' => $candidate->city_of_birth,

            // Family Details
            'father_profession' => $candidate->father_profession,
            'mother_profession' => $candidate->mother_profession,
            'family_location' => $candidate->family_location,
            'brothers_count' => $candidate->brothers_count,
            'sisters_count' => $candidate->sisters_count,
            'family_financial_status' => $candidate->family_financial_status,

            // Partner Preferences
            'pref_age_min' => $candidate->pref_age_min,
            'pref_age_max' => $candidate->pref_age_max,
            'pref_height_min' => $candidate->pref_height_min,
            'pref_height_max' => $candidate->pref_height_max,
            'pref_marital_status' => $candidate->pref_marital_status,
            'pref_religion' => $candidate->pref_religion,
            'pref_community' => $candidate->pref_community,
            'pref_mother_tongue' => $candidate->pref_mother_tongue,
            'pref_country' => $candidate->pref_country,
            'pref_state' => $candidate->pref_state,
            'pref_city' => $candidate->pref_city,
            'pref_education' => $candidate->pref_education,
            'pref_working_with' => $candidate->pref_working_with,
            'pref_profession' => $candidate->pref_profession,
            'pref_annual_income' => $candidate->pref_annual_income,
            'pref_diet' => $candidate->pref_diet,
            'pref_profile_managed_by' => $candidate->pref_profile_managed_by,

            // Contact & Privacy Settings
            'contact_display_option' => $candidate->contact_display_option,
            'photo_privacy' => $candidate->photo_privacy ?? 'all',
            'album_privacy' => $candidate->album_privacy ?? 'all',
            'hobbies_interests' => is_array($candidate->hobbies_interests) ? $candidate->hobbies_interests : [],
            'is_active' => (bool) $candidate->is_active,

            // Wallet
            'wallet' => [
                'wallet_id' => $wallet->wallet_id,
                'avl_balance' => (float) $wallet->avl_balance,
                'currency' => $wallet->currency,
                'status' => $wallet->status,
            ],

            'photos' => $photos,
            'created_at' => $candidate->created_at?->toIso8601String(),
            'updated_at' => $candidate->updated_at?->toIso8601String(),
        ];
    }

    /**
     * Clean and normalize Indian 10-digit mobile number.
     */
    protected function cleanMobile(?string $rawMobile): string
    {
        $clean = preg_replace('/[^0-9]/', '', (string) $rawMobile);
        return substr($clean, -10);
    }

    // ==========================================
    // AUTHENTICATION & OTP
    // ==========================================

    /**
     * Login - Accept mobile and send WhatsApp OTP.
     */
    public function sendOtp(Request $request): JsonResponse
    {
        $rawMobile = $request->input('mobile', '');
        $mobile = $this->cleanMobile($rawMobile);

        if (strlen($mobile) !== 10) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid 10-digit mobile number.',
            ], 422);
        }

        $candidate = Candidate::where('mobile', $mobile)
            ->orWhere('mobile', 'LIKE', "%{$mobile}")
            ->first();

        if (! $candidate) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile number not registered.',
            ], 404);
        }

        $otp = rand(1000, 9999);

        try {
            $apiKey = config('services.twilio.sid') ?: env('TWILIO_SID');
            $apiSecret = config('services.twilio.auth_token') ?: env('TWILIO_AUTH_TOKEN');
            $accountSid = config('services.twilio.account_sid') ?: env('TWILIO_ACCOUNT_SID');
            $twilioNumber = config('services.twilio.whatsapp_number') ?: env('TWILIO_WHATSAPP_NUMBER');

            if ($apiKey && $apiSecret && $accountSid && $twilioNumber) {
                $twilio = new Client($apiKey, $apiSecret, $accountSid);
                $formattedMobile = 'whatsapp:+91' . $mobile;
                $fromNumber = str_starts_with($twilioNumber, 'whatsapp:') ? $twilioNumber : 'whatsapp:' . $twilioNumber;

                $templateSid = config('services.twilio.otp_template_sid') ?: (env('TWILIO_WHATSAPP_TEMPLATE_SID') ?: 'HX669abffc47f8e40515248108fed98ad8');

                $message = $twilio->messages->create(
                    $formattedMobile,
                    [
                        'from' => $fromNumber,
                        'contentSid' => $templateSid,
                        'contentVariables' => json_encode([
                            '1' => (string) $otp,
                        ]),
                    ]
                );

                Log::info("API Login WhatsApp OTP sent to {$formattedMobile}, Twilio SID: {$message->sid}");
            }
        } catch (\Exception $e) {
            Log::error('Twilio Login OTP Error (API): ' . $e->getMessage());
        }

        Cache::put('login_otp_' . $mobile, (string) $otp, now()->addMinutes(10));
        Session::put('otp_mobile', $mobile);
        Session::put('otp_code', (string) $otp);

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to +91 ' . $mobile,
        ]);
    }

    /**
     * Verify OTP and authenticate with Laravel Sanctum token.
     */
    public function verifyOtp(Request $request): JsonResponse
    {
        $request->validate([
            'otp' => 'required|digits:4',
            'mobile' => 'nullable|string',
        ]);

        $rawMobile = $request->input('mobile', Session::get('otp_mobile'));
        $mobile = $this->cleanMobile($rawMobile);

        if (strlen($mobile) !== 10) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile number is required to verify OTP.',
            ], 422);
        }

        $sessionCode = Session::get('otp_code');
        $cacheCode = Cache::get('login_otp_' . $mobile);

        if ((string) $request->otp !== (string) $cacheCode && (string) $request->otp !== (string) $sessionCode) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP. Please try again.',
            ], 400);
        }

        $candidate = Candidate::where('mobile', $mobile)
            ->orWhere('mobile', 'LIKE', "%{$mobile}")
            ->first();

        if (! $candidate) {
            return response()->json([
                'success' => false,
                'message' => 'Candidate record not found.',
            ], 404);
        }

        // Clean up OTP cache
        Cache::forget('login_otp_' . $mobile);
        Session::forget(['otp_mobile', 'otp_code']);

        // Support session login for web requests if session exists
        if ($request->hasSession()) {
            Auth::login($candidate);
        }

        // Generate Sanctum plain text token for mobile app
        $token = $candidate->createToken('mobile_app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully.',
            'token' => $token,
            'token_type' => 'Bearer',
            'redirect' => route('dashboard'),
            'candidate' => $this->formatCandidate($candidate),
        ]);
    }

    /**
     * Logout candidate by revoking current Sanctum token.
     */
    public function logout(Request $request): JsonResponse
    {
        /** @var Candidate|null $candidate */
        $candidate = $request->user();

        if ($candidate) {
            if ($candidate->currentAccessToken()) {
                $candidate->currentAccessToken()->delete();
            } else {
                $candidate->tokens()->delete();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.',
        ]);
    }

    // ==========================================
    // REGISTRATION PRE-CHECKS & REGISTRATION OTP
    // ==========================================

    /**
     * Check if email, mobile, or aadhar already exists.
     */
    public function checkUserExists(Request $request): JsonResponse
    {
        if ($request->has('aadhar_number')) {
            $request->validate(['aadhar_number' => 'required|digits:12']);
            $exists = Candidate::where('aadhar_number', $request->aadhar_number)->first();
            if ($exists) {
                return response()->json([
                    'exists' => true,
                    'message' => 'This Aadhar Number is already registered.',
                ]);
            }
        } else {
            $mobile = $this->cleanMobile($request->input('mobile', ''));
            $email = trim((string) $request->input('email', ''));

            $exists = Candidate::where('email', $email)
                ->orWhere('mobile', $mobile)
                ->orWhere('mobile', 'LIKE', "%{$mobile}")
                ->first();

            if ($exists) {
                $field = ($exists->email === $email) ? 'Email' : 'Mobile number';

                return response()->json([
                    'exists' => true,
                    'message' => "This {$field} is already registered.",
                ]);
            }
        }

        return response()->json(['exists' => false]);
    }

    /**
     * Send OTP for Registration.
     */
    public function sendRegistrationOtp(Request $request): JsonResponse
    {
        $rawMobile = $request->input('mobile', '');
        $mobile = $this->cleanMobile($rawMobile);

        if (strlen($mobile) !== 10) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid 10-digit mobile number.',
            ], 422);
        }

        $otp = rand(1000, 9999);

        try {
            $apiKey = config('services.twilio.sid') ?: env('TWILIO_SID');
            $apiSecret = config('services.twilio.auth_token') ?: env('TWILIO_AUTH_TOKEN');
            $accountSid = config('services.twilio.account_sid') ?: env('TWILIO_ACCOUNT_SID');
            $twilioNumber = config('services.twilio.whatsapp_number') ?: env('TWILIO_WHATSAPP_NUMBER');

            if ($apiKey && $apiSecret && $accountSid && $twilioNumber) {
                $twilio = new Client($apiKey, $apiSecret, $accountSid);
                $formattedMobile = 'whatsapp:+91' . $mobile;
                $fromNumber = str_starts_with($twilioNumber, 'whatsapp:') ? $twilioNumber : 'whatsapp:' . $twilioNumber;

                $templateSid = config('services.twilio.otp_template_sid') ?: (env('TWILIO_WHATSAPP_TEMPLATE_SID') ?: 'HX669abffc47f8e40515248108fed98ad8');

                $message = $twilio->messages->create(
                    $formattedMobile,
                    [
                        'from' => $fromNumber,
                        'contentSid' => $templateSid,
                        'contentVariables' => json_encode([
                            '1' => (string) $otp,
                        ]),
                    ]
                );

                Log::info("Registration WhatsApp OTP dispatched (API) to {$formattedMobile}, Twilio SID: {$message->sid}");
            }
        } catch (\Exception $e) {
            Log::error('Twilio Registration OTP Error (API): ' . $e->getMessage());
        }

        Cache::put('reg_otp_' . $mobile, (string) $otp, now()->addMinutes(10));
        Session::put('reg_otp_code', (string) $otp);
        Session::put('reg_otp_mobile', (string) $mobile);

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to +91 ' . $mobile,
        ]);
    }

    /**
     * Verify OTP for Registration.
     */
    public function verifyRegistrationOtp(Request $request): JsonResponse
    {
        $request->validate([
            'otp' => 'required|digits:4',
            'mobile' => 'nullable|string',
        ]);

        $enteredOtp = (string) $request->otp;
        $sessionCode = (string) Session::get('reg_otp_code');
        $rawMobile = $request->input('mobile', Session::get('reg_otp_mobile'));
        $mobile = $this->cleanMobile($rawMobile);

        $cacheCode = $mobile ? (string) Cache::get('reg_otp_' . $mobile) : null;

        if ($enteredOtp !== $sessionCode && $enteredOtp !== $cacheCode) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP. Please try again.',
            ], 400);
        }

        Session::put('reg_otp_verified', true);
        if ($mobile) {
            Cache::put('reg_otp_verified_' . $mobile, true, now()->addMinutes(30));
        }

        return response()->json([
            'success' => true,
            'message' => 'Mobile number verified successfully!',
        ]);
    }

    // ==========================================
    // SELFIE VERIFICATION HELPER ENDPOINTS
    // ==========================================

    /**
     * Send Selfie Link via WhatsApp.
     */
    public function sendSelfieLink(Request $request): JsonResponse
    {
        $rawMobile = $request->input('mobile', '');
        $mobile = $this->cleanMobile($rawMobile);

        if (strlen($mobile) !== 10) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid 10-digit mobile number.',
            ], 422);
        }

        $linkParam = $mobile;

        try {
            $apiKey = config('services.twilio.sid') ?: env('TWILIO_SID');
            $apiSecret = config('services.twilio.auth_token') ?: env('TWILIO_AUTH_TOKEN');
            $accountSid = config('services.twilio.account_sid') ?: env('TWILIO_ACCOUNT_SID');
            $twilioNumber = config('services.twilio.whatsapp_number') ?: env('TWILIO_WHATSAPP_NUMBER');

            if ($apiKey && $apiSecret && $accountSid && $twilioNumber) {
                $twilio = new Client($apiKey, $apiSecret, $accountSid);
                $formattedMobile = 'whatsapp:+91' . $mobile;
                $fromNumber = str_starts_with($twilioNumber, 'whatsapp:') ? $twilioNumber : 'whatsapp:' . $twilioNumber;

                $templateSid = config('services.twilio.selfie_template_sid') ?: (env('TWILIO_WHATSAPP_SELFIE_TEMPLATE_SID') ?: 'HXd39d659900b66de60aa305cb61de868c');

                if ($templateSid) {
                    $twilio->messages->create(
                        $formattedMobile,
                        [
                            'from' => $fromNumber,
                            'contentSid' => $templateSid,
                            'contentVariables' => json_encode([
                                '1' => $linkParam,
                            ]),
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            Log::error('Twilio Selfie Link Error (API): ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Secure link sent to phone via WhatsApp.',
        ]);
    }

    /**
     * Save phone selfie to Cache.
     */
    public function savePhoneSelfie(Request $request): JsonResponse
    {
        $request->validate([
            'mobile' => 'required|string',
            'selfie_data' => 'required|string',
        ]);

        $mobile = $this->cleanMobile($request->mobile);
        Cache::put('selfie_verified_' . $mobile, $request->selfie_data, now()->addMinutes(30));

        return response()->json([
            'success' => true,
            'message' => 'Selfie data stored successfully.',
        ]);
    }

    /**
     * Check if selfie was captured (cache polling).
     */
    public function checkSelfieStatus(Request $request): JsonResponse
    {
        $rawPhone = $request->query('phone', $request->query('mobile', ''));
        $mobile = $this->cleanMobile($rawPhone);

        if (! $mobile) {
            return response()->json(['success' => false, 'message' => 'Phone number is required.'], 400);
        }

        $selfieData = Cache::get('selfie_verified_' . $mobile);

        if ($selfieData) {
            return response()->json([
                'success' => true,
                'selfie_data' => $selfieData,
            ]);
        }

        return response()->json(['success' => false]);
    }

    // ==========================================
    // REGISTRATION MASTER DATA & FINAL REGISTRATION
    // ==========================================

    /**
     * Master dropdown / lookup data for Registration & Profile screens in Flutter app.
     */
    public function registrationOptions(): JsonResponse
    {
        $religions = Religion::with('communities')->get();
        $countries = Country::with(['states.cities'])->get();
        $maritalStatuses = MaritalStatus::all();
        $heights = Height::all();
        $diets = Diet::all();
        $incomes = Income::all();
        $workingWiths = WorkingWith::all();
        $hobbies = Hobby::all();

        return response()->json([
            'success' => true,
            'data' => [
                'religions' => $religions,
                'countries' => $countries,
                'marital_statuses' => $maritalStatuses,
                'heights' => $heights,
                'diets' => $diets,
                'incomes' => $incomes,
                'working_withs' => $workingWiths,
                'hobbies' => $hobbies,
            ],
        ]);
    }

    /**
     * Process Candidate Registration and return Sanctum Token.
     */
    public function registerFinal(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'profile_for' => 'required|string',
            'gender' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'aadhar_number' => 'required|digits:12|unique:candidates,aadhar_number',
            'dob' => 'required|date',
            'religion' => 'required|string',
            'community' => 'required|string',
            'email' => 'required|email|unique:candidates,email',
            'mobile' => 'required|string|unique:candidates,mobile',

            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'police_st' => 'nullable|string',
            'pincode' => 'nullable|string',
            'full_address' => 'required|string',
            'sub_community' => 'nullable|string',
            'marital_status' => 'required|string',
            'height' => 'required|string',
            'diet' => 'required|string',

            'highest_qualification' => 'required|string',
            'college_name' => 'nullable|string',
            'college_address' => 'nullable|string',

            'income_type' => 'nullable|string',
            'annual_income' => 'required|string',
            'working_with' => 'required|string',
            'profession' => 'required|string',
            'designation' => 'required|string',
            'company_name' => 'nullable|string',
            'company_address' => 'nullable|string',

            'about_yourself' => 'nullable|string',
            'hobbies_interests' => 'nullable',
            'referral_code' => 'nullable|string|max:50',
            'profile_picture' => 'nullable',
            'selfie_image' => 'nullable',
            'selfie_data' => 'nullable|string',
        ]);

        $mobile = $this->cleanMobile($validated['mobile']);
        $validated['mobile'] = $mobile;

        // Parse hobbies_interests if passed as JSON string
        if (isset($validated['hobbies_interests']) && is_string($validated['hobbies_interests'])) {
            $decodedHobbies = json_decode($validated['hobbies_interests'], true);
            $validated['hobbies_interests'] = is_array($decodedHobbies) ? $decodedHobbies : [$validated['hobbies_interests']];
        }

        $candidateData = collect($validated)->except(['referral_code', 'selfie_image', 'selfie_data'])->toArray();
        if (empty($candidateData['income_type'])) {
            $candidateData['income_type'] = $candidateData['annual_income'];
        }

        $manager = new ImageManager(new Driver);

        // 1. Process Profile Picture (File or Base64)
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = uniqid('profile_') . '.webp';
            $path = 'profiles/' . $filename;

            $image = $manager->decodePath($file->getRealPath());
            $encoded = $image->scaleDown(1200)->encodeUsingFileExtension('webp', 70);
            Storage::disk('public')->put($path, (string) $encoded);

            $candidateData['profile_picture'] = $path;
        } elseif ($request->filled('profile_picture') && is_string($request->profile_picture) && str_starts_with($request->profile_picture, 'data:image')) {
            $filename = uniqid('profile_') . '.webp';
            $path = 'profiles/' . $filename;

            $data = preg_replace('#^data:image/\w+;base64,#i', '', $request->profile_picture);
            $decodedData = base64_decode($data);
            if ($decodedData) {
                $image = $manager->decode($decodedData);
                $encoded = $image->scaleDown(1200)->encodeUsingFileExtension('webp', 70);
                Storage::disk('public')->put($path, (string) $encoded);

                $candidateData['profile_picture'] = $path;
            }
        }

        // 2. Process Selfie Image (File, Base64 input, or Cached Selfie)
        $selfieSaved = false;
        if ($request->hasFile('selfie_image')) {
            $file = $request->file('selfie_image');
            $filename = uniqid('selfie_') . '.webp';
            $path = 'selfies/' . $filename;

            $image = $manager->decodePath($file->getRealPath());
            $encoded = $image->scaleDown(1200)->encodeUsingFileExtension('webp', 70);
            Storage::disk('public')->put($path, (string) $encoded);

            $candidateData['selfie_verified'] = true;
            $selfieSaved = true;
        } else {
            $selfieString = $request->input('selfie_data', $request->input('selfie_image'));
            if (empty($selfieString)) {
                $selfieString = Cache::get('selfie_verified_' . $mobile);
            }

            if ($selfieString && is_string($selfieString)) {
                $filename = uniqid('selfie_') . '.webp';
                $path = 'selfies/' . $filename;

                $data = preg_replace('#^data:image/\w+;base64,#i', '', $selfieString);
                $decodedData = base64_decode($data);
                if ($decodedData) {
                    $image = $manager->decode($decodedData);
                    $encoded = $image->scaleDown(1200)->encodeUsingFileExtension('webp', 70);
                    Storage::disk('public')->put($path, (string) $encoded);

                    $candidateData['selfie_verified'] = true;
                    $selfieSaved = true;
                }
            }
        }

        if (! $selfieSaved) {
            $candidateData['selfie_verified'] = true;
        }

        // Create Candidate
        $candidate = Candidate::create($candidateData);

        // Also add profile picture to CandidatePhoto table if present
        if (! empty($candidateData['profile_picture'])) {
            CandidatePhoto::create([
                'candidate_id' => $candidate->id,
                'photo_path' => $candidateData['profile_picture'],
                'is_profile_picture' => true,
            ]);
        }

        // Branch Referral Code
        if ($request->filled('referral_code')) {
            $rawCode = trim((string) $request->input('referral_code'));
            $branch = Branch::whereRaw('LOWER(code) = ?', [strtolower($rawCode)])
                ->orWhere('id', is_numeric($rawCode) ? (int) $rawCode : 0)
                ->first();

            if ($branch) {
                Referral::firstOrCreate(
                    ['candidate_id' => $candidate->id],
                    [
                        'branch_id' => $branch->id,
                        'first_wallet_recharge_amount' => 0.00,
                        'first_amount_add_date' => null,
                    ]
                );
            }
        }

        // Welcome WhatsApp Message
        try {
            $apiKey = env('TWILIO_SID');
            $apiSecret = env('TWILIO_AUTH_TOKEN');
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');

            if ($apiKey && $apiSecret && $accountSid && $twilioNumber) {
                $twilio = new Client($apiKey, $apiSecret, $accountSid);
                $formattedMobile = 'whatsapp:+91' . ltrim($candidate->mobile, '0');
                $templateSid = 'HX05336e99a055aea550db5d5e69e6fbf0';

                $twilio->messages->create(
                    $formattedMobile,
                    [
                        'from' => $twilioNumber,
                        'contentSid' => $templateSid,
                        'contentVariables' => json_encode([
                            '1' => $candidate->first_name,
                        ]),
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error('Welcome WhatsApp Message Error (API): ' . $e->getMessage());
        }

        // New Candidate Registration Email to Admin
        try {
            $adminEmail = env('ADMIN_NOTIFICATION_EMAIL', 'sumatra.sales2424@gmail.com') ?: 'sumatra.sales2424@gmail.com';
            Mail::to($adminEmail)->send(new NewCandidateRegistrationAdminMail($candidate, isset($branch) && $branch ? $branch : null));
        } catch (\Exception $e) {
            Log::error('Admin Registration Email Notification Error (API): ' . $e->getMessage());
        }

        // Clear selfie & registration cache
        Cache::forget('selfie_verified_' . $mobile);
        Cache::forget('reg_otp_' . $mobile);
        Cache::forget('reg_otp_verified_' . $mobile);

        // Support session login for web requests if session exists
        if ($request->hasSession()) {
            Auth::login($candidate);
        }

        // Generate Sanctum plain text token for mobile app
        $token = $candidate->createToken('mobile_app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Candidate registered successfully.',
            'token' => $token,
            'token_type' => 'Bearer',
            'redirect' => route('dashboard'),
            'candidate' => $this->formatCandidate($candidate),
        ], 201);
    }

    // ==========================================
    // CANDIDATE DASHBOARD
    // ==========================================

    /**
     * Candidate dashboard with metrics, recommendations, and notifications.
     */
    public function dashboard(Request $request): JsonResponse
    {
        /** @var Candidate $candidate */
        $candidate = $request->user();
        $wallet = $candidate->getOrCreateWallet();

        // 1. Activity Summary Metrics
        $pendingInvitationsCount = ConnectionRequest::where('receiver_id', $candidate->id)
            ->where('status', 'pending')
            ->count();

        $acceptedInvitationsCount = ConnectionRequest::where('status', 'accepted')
            ->where(function ($q) use ($candidate) {
                $q->where('sender_id', $candidate->id)
                    ->orWhere('receiver_id', $candidate->id);
            })
            ->count();

        $shortlistedCount = Shortlisted::where('candidate_id', $candidate->id)->count();
        $recentVisitorsCount = max(3, $shortlistedCount + ConnectionRequest::where('receiver_id', $candidate->id)->count());

        $contactsViewedCount = WhatsAppChatRequest::where('status', 'accepted')
            ->where(function ($q) use ($candidate) {
                $q->where('sender_id', $candidate->id)
                    ->orWhere('receiver_id', $candidate->id);
            })
            ->count();

        // 2. Profile Completeness Calculation
        $criticalFields = [
            'first_name', 'last_name', 'dob', 'gender', 'religion', 'community',
            'city', 'state', 'highest_qualification', 'profession', 'annual_income',
            'about_yourself', 'profile_picture', 'selfie_verified', 'pref_age_min', 'pref_religion',
        ];
        $filledCount = 0;
        foreach ($criticalFields as $f) {
            if (! empty($candidate->$f)) {
                $filledCount++;
            }
        }
        $profileCompleteness = (int) round(($filledCount / count($criticalFields)) * 100);

        // 3. Dynamic Matches for Dashboard
        $userGender = strtolower(trim($candidate->gender ?? ''));
        $targetGender = ($userGender === 'male' || $userGender === 'man') ? 'Female' : 'Male';

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

        $matchesController = new MatchesController;
        $todaysMatches = $matchesController->getMatchesData(
            $candidate,
            $targetGender,
            'todays',
            $shortlistedIds,
            $sentInterestIds,
            $receivedInterestIds,
            $acceptedCandidateIds
        );

        $dashboardMatches = array_slice($todaysMatches, 0, 4);

        // Ensure match photo urls are absolute
        foreach ($dashboardMatches as &$m) {
            if (isset($m['photo'])) {
                $m['photo'] = $this->formatUrl($m['photo']);
            }
        }

        // 4. Notifications Feed
        NotificationService::syncCandidateNotifications($candidate);

        if (! $candidate->is_bluetick_verified) {
            $hasNotif = Notification::where('candidate_id', $candidate->id)
                ->where('type', 'bluetick_verification_tip')
                ->exists();
            if (! $hasNotif) {
                Notification::create([
                    'candidate_id' => $candidate->id,
                    'type' => 'bluetick_verification_tip',
                    'title' => 'Blue Tick Verification',
                    'message' => 'Boost your profile visibility by completing Selfie & Aadhaar Verification.',
                    'photo' => $this->formatUrl('logo.png'),
                    'action_url' => '/bluetick-verification',
                    'badge' => 'Action Required',
                    'is_read' => false,
                    'is_dismissed' => false,
                ]);
            }
        }

        $dbNotifications = Notification::where('candidate_id', $candidate->id)
            ->where('is_dismissed', false)
            ->orderByDesc('id')
            ->take(10)
            ->get();

        $notifications = [];
        foreach ($dbNotifications as $dn) {
            $photo = $dn->photo;
            if (empty($photo)) {
                $photo = 'https://ui-avatars.com/api/?name=' . urlencode($dn->title ?: 'Rani') . '&background=fdf2f8&color=db2777';
            } else {
                $photo = $this->formatUrl($photo);
            }

            $notifications[] = [
                'id' => $dn->id,
                'name' => $dn->title,
                'photo' => $photo,
                'text' => $dn->message,
                'time_ago' => $dn->created_at ? $dn->created_at->diffForHumans() : 'Recently',
                'link' => $dn->action_url ?: '/inbox',
                'is_new' => ! $dn->is_read,
                'badge' => $dn->badge ?: 'Notification',
            ];
        }

        $unreadNotificationsCount = Notification::where('candidate_id', $candidate->id)
            ->where('is_read', false)
            ->where('is_dismissed', false)
            ->count();

        $candidateBluetick = Bluetick::where('candidate_id', $candidate->id)->latest()->first();

        return response()->json([
            'success' => true,
            'data' => [
                'candidate' => $this->formatCandidate($candidate),
                'wallet' => [
                    'wallet_id' => $wallet->wallet_id,
                    'avl_balance' => (float) $wallet->avl_balance,
                    'currency' => $wallet->currency,
                    'status' => $wallet->status,
                ],
                'metrics' => [
                    'pending_invitations_count' => $pendingInvitationsCount,
                    'accepted_invitations_count' => $acceptedInvitationsCount,
                    'shortlisted_count' => $shortlistedCount,
                    'recent_visitors_count' => $recentVisitorsCount,
                    'contacts_viewed_count' => $contactsViewedCount,
                    'profile_completeness' => $profileCompleteness,
                    'unread_notifications_count' => $unreadNotificationsCount,
                ],
                'matches' => $dashboardMatches,
                'notifications' => $notifications,
                'bluetick' => $candidateBluetick ? [
                    'id' => $candidateBluetick->id,
                    'is_accept' => (int) $candidateBluetick->is_accept,
                    'status' => match ((int) $candidateBluetick->is_accept) {
                        1 => 'verified',
                        2 => 'rejected',
                        default => 'pending',
                    },
                    'admin_notes' => $candidateBluetick->admin_notes,
                ] : null,
                'ids' => [
                    'shortlisted_ids' => $shortlistedIds,
                    'sent_interest_ids' => $sentInterestIds,
                    'received_interest_ids' => $receivedInterestIds,
                    'accepted_profile_codes' => $acceptedProfileCodes,
                ],
            ],
        ]);
    }

    // ==========================================
    // BLUE TICK AADHAAR VERIFICATION
    // ==========================================

    /**
     * Get candidate Blue Tick verification status and previous submission.
     */
    public function showBlueTickVerification(Request $request): JsonResponse
    {
        /** @var Candidate $candidate */
        $candidate = $request->user();
        $existingBluetick = Bluetick::where('candidate_id', $candidate->id)->latest()->first();

        return response()->json([
            'success' => true,
            'candidate' => [
                'id' => $candidate->id,
                'candidate_code' => $candidate->getDisplayCodeAttribute(),
                'aadhar_number' => $candidate->aadhar_number,
                'is_bluetick_verified' => (bool) $candidate->is_bluetick_verified,
            ],
            'bluetick' => $existingBluetick ? [
                'id' => $existingBluetick->id,
                'aadhar_number' => $existingBluetick->aadhar_number,
                'aadhar_photo_front_url' => $this->formatUrl($existingBluetick->aadhar_photo_front),
                'aadhar_photo_back_url' => $this->formatUrl($existingBluetick->aadhar_photo_back),
                'is_accept' => (int) $existingBluetick->is_accept,
                'status' => match ((int) $existingBluetick->is_accept) {
                    1 => 'verified',
                    2 => 'rejected',
                    default => 'pending',
                },
                'admin_notes' => $existingBluetick->admin_notes,
                'created_at' => $existingBluetick->created_at?->toIso8601String(),
            ] : null,
        ]);
    }

    /**
     * Validate entered Aadhaar Number against registered profile Aadhaar number.
     */
    public function validateAadhar(Request $request): JsonResponse
    {
        $request->validate([
            'aadhar_number' => 'required|string',
        ]);

        /** @var Candidate $candidate */
        $candidate = $request->user();

        $inputAadhar = preg_replace('/[^0-9]/', '', (string) $request->aadhar_number);
        $registeredAadhar = preg_replace('/[^0-9]/', '', (string) ($candidate->aadhar_number ?? ''));

        if (strlen($inputAadhar) !== 12) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid 12-digit Aadhaar number.',
            ], 422);
        }

        if (! empty($registeredAadhar) && $inputAadhar !== $registeredAadhar) {
            return response()->json([
                'success' => false,
                'message' => 'Aadhaar number does not match your registered profile Aadhaar number.',
            ], 422);
        }

        if (empty($registeredAadhar)) {
            $candidate->aadhar_number = $inputAadhar;
            $candidate->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Aadhaar number verified successfully.',
            'clean_aadhar' => $inputAadhar,
        ]);
    }

    /**
     * Submit Blue Tick verification with Front & Back Aadhaar photos.
     */
    public function submitBlueTickVerification(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'aadhar_number' => 'required|string',
                'aadhar_photo_front' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
                'aadhar_photo_back' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            ]);

            /** @var Candidate $candidate */
            $candidate = $request->user();

            if (! $candidate) {
                return response()->json([
                    'success' => false,
                    'message' => 'User session expired. Please log in again.',
                ], 401);
            }

            $inputAadhar = preg_replace('/[^0-9]/', '', $request->aadhar_number);
            $registeredAadhar = preg_replace('/[^0-9]/', '', (string) ($candidate->aadhar_number ?? ''));

            if (! empty($registeredAadhar) && $inputAadhar !== $registeredAadhar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aadhaar number does not match your registered profile Aadhaar number.',
                ], 422);
            }

            if (empty($registeredAadhar)) {
                $candidate->aadhar_number = $inputAadhar;
                $candidate->save();
            }

            $frontFile = $request->file('aadhar_photo_front');
            $backFile = $request->file('aadhar_photo_back');

            $frontFilename = 'aadhar_front_' . $candidate->id . '_' . time() . '.' . $frontFile->getClientOriginalExtension();
            $backFilename = 'aadhar_back_' . $candidate->id . '_' . time() . '.' . $backFile->getClientOriginalExtension();

            $frontPath = $frontFile->storeAs('aadhar_cards', $frontFilename, 'public');
            $backPath = $backFile->storeAs('aadhar_cards', $backFilename, 'public');

            $bluetick = Bluetick::updateOrCreate(
                ['candidate_id' => $candidate->id],
                [
                    'aadhar_number' => $inputAadhar,
                    'aadhar_photo_front' => $frontPath,
                    'aadhar_photo_back' => $backPath,
                    'is_accept' => 0,
                    'admin_notes' => null,
                ]
            );

            try {
                NotificationService::createNotification(
                    $candidate->id,
                    'bluetick_status',
                    'Blue Tick Verification Submitted',
                    'Your Aadhaar verification documents have been submitted and are under review. The verification process takes 24-48 hours.',
                    null,
                    $this->formatUrl('logo.png'),
                    '/bluetick-verification',
                    'Under Review'
                );
            } catch (\Exception $ne) {
                Log::warning('Failed to create in-app notification: ' . $ne->getMessage());
            }

            try {
                NotificationService::dispatchBlueTickSubmittedWhatsApp($candidate);
            } catch (\Exception $we) {
                Log::warning('Failed to send WhatsApp bluetick alert: ' . $we->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Verification request submitted successfully! It will take 24-48 hours for our team to complete the verification process.',
                'bluetick' => [
                    'id' => $bluetick->id,
                    'aadhar_number' => $inputAadhar,
                    'aadhar_photo_front_url' => $this->formatUrl($frontPath),
                    'aadhar_photo_back_url' => $this->formatUrl($backPath),
                    'is_accept' => 0,
                    'status' => 'pending',
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json([
                'success' => false,
                'message' => $ve->validator->errors()->first() ?: 'Invalid submission data.',
                'errors' => $ve->validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error submitting Blue Tick verification (API): ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving your verification documents. Please try again.',
            ], 500);
        }
    }

    // ==========================================
    // NOTIFICATIONS
    // ==========================================

    /**
     * Mark notification as read and dismissed.
     */
    public function markNotificationRead(Request $request, $id): JsonResponse
    {
        /** @var Candidate $candidate */
        $candidate = $request->user();

        $notification = Notification::where('candidate_id', $candidate->id)->find($id);
        if ($notification) {
            $notification->is_read = true;
            $notification->is_dismissed = true;
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read.',
                'redirect_url' => $notification->action_url ?: '/inbox',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Notification not found.',
        ], 404);
    }

    // ==========================================
    // PROFILE MANAGEMENT
    // ==========================================

    /**
     * Candidate Profile Details along with master options.
     */
    public function myProfile(Request $request): JsonResponse
    {
        /** @var Candidate $candidate */
        $candidate = $request->user();

        $religions = Religion::with('communities')->get();
        $countries = Country::with(['states.cities'])->get();
        $maritalStatuses = MaritalStatus::all();
        $heights = Height::all();
        $diets = Diet::all();
        $incomes = Income::all();
        $workingWiths = WorkingWith::all();
        $hobbies = Hobby::all();

        return response()->json([
            'success' => true,
            'candidate' => $this->formatCandidate($candidate),
            'options' => [
                'religions' => $religions,
                'countries' => $countries,
                'marital_statuses' => $maritalStatuses,
                'heights' => $heights,
                'diets' => $diets,
                'incomes' => $incomes,
                'working_withs' => $workingWiths,
                'hobbies' => $hobbies,
            ],
        ]);
    }

    /**
     * Update Profile section or general profile fields.
     */
    public function updateProfile(Request $request): JsonResponse
    {
        /** @var Candidate $candidate */
        $candidate = $request->user();
        $section = $request->input('section');
        $rules = [];

        switch ($section) {
            case 'about':
                $rules = [
                    'about_yourself' => 'nullable|string',
                    'hobbies_interests' => 'nullable',
                ];
                break;
            case 'basic':
                $rules = [
                    'gender' => 'nullable|string|in:Male,Female,male,female',
                    'first_name' => 'nullable|string|max:100',
                    'middle_name' => 'nullable|string|max:100',
                    'last_name' => 'nullable|string|max:100',
                    'dob' => 'nullable|date',
                    'marital_status' => 'nullable|string|max:100',
                    'height' => 'nullable|string|max:50',
                    'diet' => 'nullable|string|max:100',
                    'blood_group' => 'nullable|string|max:20',
                    'health_info' => 'nullable|string|max:255',
                    'grew_up_in' => 'nullable|string|max:255',
                    'disability' => 'nullable|string|max:100',
                ];
                break;
            case 'religious':
                $rules = [
                    'religion' => 'nullable|string|max:100',
                    'community' => 'nullable|string|max:100',
                    'sub_community' => 'nullable|string|max:100',
                    'gothra' => 'nullable|string|max:100',
                    'mother_tongue' => 'nullable|string|max:100',
                ];
                break;
            case 'location':
                $rules = [
                    'country' => 'nullable|string|max:100',
                    'state' => 'nullable|string|max:100',
                    'city' => 'nullable|string|max:100',
                    'police_st' => 'nullable|string|max:150',
                    'pincode' => 'nullable|string|max:30',
                    'zip_code' => 'nullable|string|max:30',
                    'residency_status' => 'nullable|string|max:100',
                    'full_address' => 'nullable|string|max:500',
                ];
                break;
            case 'education_career':
                $rules = [
                    'highest_qualification' => 'nullable|string|max:150',
                    'working_with' => 'nullable|string|max:150',
                    'college_name' => 'nullable|string|max:200',
                    'college_address' => 'nullable|string|max:255',
                    'profession' => 'nullable|string|max:150',
                    'designation' => 'nullable|string|max:150',
                    'annual_income' => 'nullable|string|max:100',
                    'income_type' => 'nullable|string|max:100',
                    'company_name' => 'nullable|string|max:200',
                    'company_address' => 'nullable|string|max:255',
                ];
                break;
            case 'astro':
                $rules = [
                    'manglik' => 'nullable|string|max:50',
                    'time_of_birth' => 'nullable|string|max:50',
                    'city_of_birth' => 'nullable|string|max:150',
                ];
                break;
            case 'family':
                $rules = [
                    'father_profession' => 'nullable|string|max:150',
                    'mother_profession' => 'nullable|string|max:150',
                    'family_location' => 'nullable|string|max:200',
                    'brothers_count' => 'nullable|integer|min:0|max:20',
                    'sisters_count' => 'nullable|integer|min:0|max:20',
                    'family_financial_status' => 'nullable|string|max:100',
                ];
                break;
            case 'partner_preferences':
                $rules = [
                    'pref_age_min' => 'nullable|integer|min:18|max:80',
                    'pref_age_max' => 'nullable|integer|min:18|max:80',
                    'pref_height_min' => 'nullable|string|max:50',
                    'pref_height_max' => 'nullable|string|max:50',
                    'pref_marital_status' => 'nullable|string|max:100',
                    'pref_religion' => 'nullable|string|max:100',
                    'pref_community' => 'nullable|string|max:100',
                    'pref_mother_tongue' => 'nullable|string|max:100',
                    'pref_country' => 'nullable|string|max:100',
                    'pref_state' => 'nullable|string|max:100',
                    'pref_city' => 'nullable|string|max:100',
                    'pref_education' => 'nullable|string|max:150',
                    'pref_working_with' => 'nullable|string|max:150',
                    'pref_profession' => 'nullable|string|max:150',
                    'pref_annual_income' => 'nullable|string|max:100',
                    'pref_diet' => 'nullable|string|max:100',
                    'pref_profile_managed_by' => 'nullable|string|max:100',
                ];
                break;
            case 'contact':
                $rules = [
                    'contact_display_option' => 'nullable|string|max:255',
                ];
                break;
            default:
                if (! empty($section)) {
                    return response()->json(['success' => false, 'message' => 'Invalid section.'], 400);
                }
                // Allow direct key updates if section is not provided
                $rules = [
                    'about_yourself' => 'nullable|string',
                    'first_name' => 'nullable|string|max:100',
                    'last_name' => 'nullable|string|max:100',
                    'marital_status' => 'nullable|string',
                    'height' => 'nullable|string',
                    'diet' => 'nullable|string',
                    'annual_income' => 'nullable|string',
                    'working_with' => 'nullable|string',
                    'profession' => 'nullable|string',
                    'designation' => 'nullable|string',
                    'city' => 'nullable|string',
                    'state' => 'nullable|string',
                    'country' => 'nullable|string',
                    'hobbies_interests' => 'nullable',
                ];
                break;
        }

        $validated = $request->validate($rules);

        if (isset($validated['hobbies_interests']) && is_string($validated['hobbies_interests'])) {
            $decoded = json_decode($validated['hobbies_interests'], true);
            $validated['hobbies_interests'] = is_array($decoded) ? $decoded : [$validated['hobbies_interests']];
        }

        $candidate->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'candidate' => $this->formatCandidate($candidate->fresh()),
        ]);
    }

    /**
     * Upload Profile Picture.
     */
    public function uploadProfilePicture(Request $request): JsonResponse
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,webp|max:15360',
        ]);

        /** @var Candidate $candidate */
        $candidate = $request->user();

        $manager = new ImageManager(new Driver);

        $file = $request->file('profile_picture');
        $filename = uniqid('profile_') . '.webp';
        $path = 'profiles/' . $filename;

        $image = $manager->decodePath($file->getRealPath());
        $encoded = $image->scaleDown(1200)->encodeUsingFileExtension('webp', 70);
        Storage::disk('public')->put($path, (string) $encoded);

        $oldProfilePath = $candidate->profile_picture;

        if ($oldProfilePath && $oldProfilePath !== $path && Storage::disk('public')->exists($oldProfilePath)) {
            Storage::disk('public')->delete($oldProfilePath);
        }

        $candidate->update(['profile_picture' => $path]);

        $existingProfilePhoto = CandidatePhoto::where('candidate_id', $candidate->id)
            ->where(function ($q) use ($oldProfilePath) {
                $q->where('is_profile_picture', true);
                if ($oldProfilePath) {
                    $q->orWhere('photo_path', $oldProfilePath);
                }
            })
            ->first();

        CandidatePhoto::where('candidate_id', $candidate->id)->update(['is_profile_picture' => false]);

        if ($existingProfilePhoto) {
            $existingProfilePhoto->update([
                'photo_path' => $path,
                'is_profile_picture' => true,
            ]);
        } else {
            CandidatePhoto::create([
                'candidate_id' => $candidate->id,
                'photo_path' => $path,
                'is_profile_picture' => true,
            ]);
        }

        // Clean up broken photo records
        $candidatePhotos = CandidatePhoto::where('candidate_id', $candidate->id)->get();
        foreach ($candidatePhotos as $p) {
            if (! Storage::disk('public')->exists($p->photo_path)) {
                $p->delete();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile picture updated successfully.',
            'image_url' => $this->formatUrl($path),
            'candidate' => $this->formatCandidate($candidate->fresh()),
        ]);
    }

    /**
     * Get candidate photos gallery.
     */
    public function myPhotos(Request $request): JsonResponse
    {
        /** @var Candidate $candidate */
        $candidate = $request->user();

        // Clean up broken/orphaned photo records
        $existingPhotos = CandidatePhoto::where('candidate_id', $candidate->id)->get();
        foreach ($existingPhotos as $photoItem) {
            if (! Storage::disk('public')->exists($photoItem->photo_path)) {
                $photoItem->delete();
            }
        }

        // Auto-sync candidate's active profile picture into candidate_photos
        if ($candidate->profile_picture && Storage::disk('public')->exists($candidate->profile_picture)) {
            $existingProfilePhoto = CandidatePhoto::where('candidate_id', $candidate->id)
                ->where('photo_path', $candidate->profile_picture)
                ->first();

            if (! $existingProfilePhoto) {
                CandidatePhoto::where('candidate_id', $candidate->id)->update(['is_profile_picture' => false]);
                CandidatePhoto::create([
                    'candidate_id' => $candidate->id,
                    'photo_path' => $candidate->profile_picture,
                    'is_profile_picture' => true,
                ]);
            } else {
                CandidatePhoto::where('candidate_id', $candidate->id)
                    ->where('id', '!=', $existingProfilePhoto->id)
                    ->update(['is_profile_picture' => false]);
                $existingProfilePhoto->update(['is_profile_picture' => true]);
            }
        }

        $photos = CandidatePhoto::where('candidate_id', $candidate->id)
            ->orderBy('is_profile_picture', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $formattedPhotos = $photos->map(function ($photo) {
            return [
                'id' => $photo->id,
                'url' => $this->formatUrl($photo->photo_path),
                'is_profile_picture' => (bool) $photo->is_profile_picture,
                'created_at' => $photo->created_at ? $photo->created_at->diffForHumans() : '',
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => [
                'profile_picture_url' => $this->formatUrl($candidate->profile_picture),
                'photo_privacy' => $candidate->photo_privacy ?? 'all',
                'album_privacy' => $candidate->album_privacy ?? 'all',
                'photos' => $formattedPhotos,
            ],
        ]);
    }

    /**
     * Upload one or multiple photos to Gallery.
     */
    public function uploadGalleryPhotos(Request $request): JsonResponse
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $files = [];
        if ($request->hasFile('photos')) {
            $uploaded = $request->file('photos');
            $files = is_array($uploaded) ? $uploaded : [$uploaded];
        } elseif ($request->hasFile('photo')) {
            $files = [$request->file('photo')];
        }

        if (empty($files)) {
            return response()->json([
                'success' => false,
                'message' => 'No image file was provided or upload size limit was exceeded.',
            ], 422);
        }

        /** @var Candidate $candidate */
        $candidate = $request->user();
        $currentCount = CandidatePhoto::where('candidate_id', $candidate->id)->count();
        $newCount = count($files);

        if ($currentCount + $newCount > 20) {
            $allowed = max(0, 20 - $currentCount);

            return response()->json([
                'success' => false,
                'message' => "You can upload at most {$allowed} more photo(s) (maximum 20 total).",
            ], 422);
        }

        $manager = new ImageManager(new Driver);
        $uploadedPhotos = [];
        $hasProfilePic = $candidate->profile_picture && Storage::disk('public')->exists($candidate->profile_picture);

        foreach ($files as $index => $file) {
            if (! $file->isValid()) {
                continue;
            }

            $filename = uniqid('gallery_' . $candidate->id . '_') . '.webp';
            $path = 'gallery/' . $filename;

            $image = $manager->decodePath($file->getRealPath());
            $encoded = $image->scaleDown(1600)->encodeUsingFileExtension('webp', 75);
            Storage::disk('public')->put($path, (string) $encoded);

            $isFirst = (! $hasProfilePic && $index === 0 && $currentCount === 0);

            $photoRecord = CandidatePhoto::create([
                'candidate_id' => $candidate->id,
                'photo_path' => $path,
                'is_profile_picture' => $isFirst,
            ]);

            if ($isFirst) {
                $candidate->update(['profile_picture' => $path]);
                $hasProfilePic = true;
            }

            $uploadedPhotos[] = [
                'id' => $photoRecord->id,
                'url' => $this->formatUrl($path),
                'is_profile_picture' => (bool) $photoRecord->is_profile_picture,
                'created_at' => $photoRecord->created_at ? $photoRecord->created_at->diffForHumans() : '',
            ];
        }

        return response()->json([
            'success' => true,
            'message' => count($uploadedPhotos) . ' photo(s) uploaded successfully.',
            'photos' => $uploadedPhotos,
        ]);
    }

    /**
     * Crop an existing gallery photo.
     */
    public function cropGalleryPhoto(Request $request): JsonResponse
    {
        $request->validate([
            'photo_id' => 'required|integer',
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:15360',
            'set_as_profile' => 'nullable|boolean',
        ]);

        /** @var Candidate $candidate */
        $candidate = $request->user();
        $photo = CandidatePhoto::where('id', $request->photo_id)
            ->where('candidate_id', $candidate->id)
            ->first();

        if (! $photo) {
            return response()->json(['success' => false, 'message' => 'Photo not found.'], 404);
        }

        $manager = new ImageManager(new Driver);
        $file = $request->file('photo');
        $filename = uniqid('gallery_' . $candidate->id . '_') . '.webp';
        $path = 'gallery/' . $filename;

        $image = $manager->decodePath($file->getRealPath());
        $encoded = $image->scaleDown(1600)->encodeUsingFileExtension('webp', 75);
        Storage::disk('public')->put($path, (string) $encoded);

        $oldPath = $photo->photo_path;
        if ($oldPath && $oldPath !== $path && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        $setAsProfile = $request->boolean('set_as_profile') || (bool) $photo->is_profile_picture;

        if ($setAsProfile) {
            CandidatePhoto::where('candidate_id', $candidate->id)->update(['is_profile_picture' => false]);
            $photo->update([
                'photo_path' => $path,
                'is_profile_picture' => true,
            ]);
            $candidate->update(['profile_picture' => $path]);
        } else {
            $photo->update([
                'photo_path' => $path,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Photo cropped and updated successfully.',
            'photo_id' => $photo->id,
            'image_url' => $this->formatUrl($path),
            'is_profile_picture' => (bool) $photo->is_profile_picture,
            'profile_url' => $candidate->profile_picture ? $this->formatUrl($candidate->profile_picture) : null,
        ]);
    }

    /**
     * Set a gallery photo as the main profile picture.
     */
    public function setProfilePhoto(Request $request): JsonResponse
    {
        $request->validate([
            'photo_id' => 'required|integer',
        ]);

        /** @var Candidate $candidate */
        $candidate = $request->user();
        $photo = CandidatePhoto::where('id', $request->photo_id)
            ->where('candidate_id', $candidate->id)
            ->first();

        if (! $photo) {
            return response()->json(['success' => false, 'message' => 'Photo not found.'], 404);
        }

        CandidatePhoto::where('candidate_id', $candidate->id)->update(['is_profile_picture' => false]);
        $photo->update(['is_profile_picture' => true]);
        $candidate->update(['profile_picture' => $photo->photo_path]);

        return response()->json([
            'success' => true,
            'message' => 'Profile picture set successfully.',
            'image_url' => $this->formatUrl($photo->photo_path),
        ]);
    }

    /**
     * Delete a gallery photo.
     */
    public function deletePhoto(Request $request): JsonResponse
    {
        $request->validate([
            'photo_id' => 'required|integer',
        ]);

        /** @var Candidate $candidate */
        $candidate = $request->user();
        $photo = CandidatePhoto::where('id', $request->photo_id)
            ->where('candidate_id', $candidate->id)
            ->first();

        if (! $photo) {
            return response()->json(['success' => false, 'message' => 'Photo not found.'], 404);
        }

        $wasProfilePic = $photo->is_profile_picture || ($candidate->profile_picture === $photo->photo_path);

        if (Storage::disk('public')->exists($photo->photo_path)) {
            Storage::disk('public')->delete($photo->photo_path);
        }

        $photo->delete();

        $newProfileUrl = null;
        if ($wasProfilePic) {
            $nextPhoto = CandidatePhoto::where('candidate_id', $candidate->id)->latest()->first();
            if ($nextPhoto) {
                $nextPhoto->update(['is_profile_picture' => true]);
                $candidate->update(['profile_picture' => $nextPhoto->photo_path]);
                $newProfileUrl = $this->formatUrl($nextPhoto->photo_path);
            } else {
                $candidate->update(['profile_picture' => null]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Photo deleted successfully.',
            'was_profile_picture' => $wasProfilePic,
            'new_profile_url' => $newProfileUrl,
        ]);
    }

    /**
     * Update Photo Privacy & Album Settings.
     */
    public function updatePhotoSettings(Request $request): JsonResponse
    {
        $request->validate([
            'photo_privacy' => 'required|string|max:255',
            'album_privacy' => 'required|string|max:255',
        ]);

        /** @var Candidate $candidate */
        $candidate = $request->user();
        $candidate->update([
            'photo_privacy' => $request->photo_privacy,
            'album_privacy' => $request->album_privacy,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Photo privacy settings updated successfully.',
        ]);
    }
}
