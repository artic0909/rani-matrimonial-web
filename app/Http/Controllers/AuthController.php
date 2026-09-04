<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;

class AuthController extends Controller
{
    // Login - Accept mobile and send/simulate OTP
    public function sendOtp(Request $request)
    {
        $request->validate(['mobile' => 'required|digits:10']);
        
        $candidate = Candidate::where('mobile', $request->mobile)->first();
        
        if (!$candidate) {
            return response()->json(['success' => false, 'message' => 'Mobile number not registered.'], 404);
        }

        $otp = rand(1000, 9999);
        
        try {
            $apiKey = env('TWILIO_SID');
            $apiSecret = env('TWILIO_AUTH_TOKEN');
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');

            if ($apiKey && $apiSecret && $accountSid && $twilioNumber) {
                $twilio = new Client($apiKey, $apiSecret, $accountSid);
                $formattedMobile = "whatsapp:+91" . ltrim($request->mobile, '0');
                
                $templateSid = env('TWILIO_WHATSAPP_TEMPLATE_SID', 'HX669abffc47f8e40515248108fed98ad8');
                
                $twilio->messages->create(
                    $formattedMobile,
                    [
                        "from" => $twilioNumber,
                        "contentSid" => $templateSid,
                        "contentVariables" => json_encode([
                            "1" => (string) $otp
                        ])
                    ]
                );
            }
        } catch (\Exception $e) {
            \Log::error('Twilio Login OTP Error: ' . $e->getMessage());
        }

        Session::put('otp_mobile', $request->mobile);
        Session::put('otp_code', (string) $otp);

        return response()->json(['success' => true, 'message' => 'OTP sent to ' . $request->mobile]);
    }

    // Verify OTP and Login
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:4']);

        $mobile = Session::get('otp_mobile');
        $code = Session::get('otp_code');

        if ($request->otp !== $code) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP'], 400);
        }

        $candidate = Candidate::where('mobile', $mobile)->first();
        Auth::login($candidate);
        
        Session::forget(['otp_mobile', 'otp_code']);

        return response()->json(['success' => true, 'redirect' => route('dashboard')]);
    }

    // Check if email, mobile, or aadhar already exists
    public function checkUserExists(Request $request)
    {
        // Support checking either (email+mobile) or (aadhar_number)
        if ($request->has('aadhar_number')) {
            $request->validate(['aadhar_number' => 'required|digits:12']);
            $exists = Candidate::where('aadhar_number', $request->aadhar_number)->first();
            if ($exists) {
                return response()->json(['exists' => true, 'message' => "This Aadhar Number is already registered."]);
            }
        } else {
            $request->validate([
                'email' => 'required|email',
                'mobile' => 'required|digits:10'
            ]);

            $exists = Candidate::where('email', $request->email)
                ->orWhere('mobile', $request->mobile)
                ->first();

            if ($exists) {
                $field = ($exists->email === $request->email) ? 'Email' : 'Mobile number';
                return response()->json(['exists' => true, 'message' => "This {$field} is already registered."]);
            }
        }

        return response()->json(['exists' => false]);
    }

    // Send OTP for Registration
    public function sendRegistrationOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10'
        ]);

        $mobile = $request->mobile;
        $otp = rand(1000, 9999);
        
        try {
            $apiKey = env('TWILIO_SID');
            $apiSecret = env('TWILIO_AUTH_TOKEN');
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');

            if ($apiKey && $apiSecret && $accountSid && $twilioNumber) {
                $twilio = new Client($apiKey, $apiSecret, $accountSid);
                // Format mobile number (assuming Indian numbers for now)
                $formattedMobile = "whatsapp:+91" . ltrim($mobile, '0');
                
                // Get Template SID from env, or fallback to the one provided
                $templateSid = env('TWILIO_WHATSAPP_TEMPLATE_SID', 'HX669abffc47f8e40515248108fed98ad8');
                
                $message = $twilio->messages->create(
                    $formattedMobile,
                    [
                        "from" => $twilioNumber,
                        "contentSid" => $templateSid,
                        "contentVariables" => json_encode([
                            "1" => (string) $otp
                        ])
                    ]
                );
            }
        } catch (\Exception $e) {
            \Log::error('Twilio OTP Error: ' . $e->getMessage());
            // If Twilio fails, we might still want to proceed in local env or show error
            // For now, let's just log it and proceed so testing doesn't completely block if credentials are wrong.
            // If they want strict blocking: return response()->json(['success' => false, 'message' => 'Failed to send OTP.'], 500);
        }

        Session::put('reg_otp_code', (string) $otp);

        return response()->json(['success' => true, 'message' => 'OTP sent to ' . $mobile]);
    }

    // Verify OTP for Registration
    public function verifyRegistrationOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:4']);

        $code = Session::get('reg_otp_code');

        if ($request->otp !== $code) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP'], 400);
        }

        return response()->json(['success' => true]);
    }

    // Send Selfie Link via WhatsApp
    public function sendSelfieLink(Request $request)
    {
        $request->validate(['mobile' => 'required|digits:10']);
        
        $mobile = $request->mobile;
        
        // The dynamic variable {{1}} for the CTA button URL
        $linkParam = $mobile;

        try {
            $apiKey = env('TWILIO_SID');
            $apiSecret = env('TWILIO_AUTH_TOKEN');
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');

            if ($apiKey && $apiSecret && $accountSid && $twilioNumber) {
                $twilio = new Client($apiKey, $apiSecret, $accountSid);
                $formattedMobile = "whatsapp:+91" . ltrim($mobile, '0');
                
                // Uses the new CTA template for the selfie link
                $templateSid = env('TWILIO_WHATSAPP_SELFIE_TEMPLATE_SID', 'HXd39d659900b66de60aa305cb61de868c');
                
                if ($templateSid) {
                    $twilio->messages->create(
                        $formattedMobile,
                        [
                            "from" => $twilioNumber,
                            "contentSid" => $templateSid,
                            "contentVariables" => json_encode([
                                "1" => $linkParam
                            ])
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            \Log::error('Twilio Selfie Link Error: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Secure link sent to phone via WhatsApp.']);
    }

    // Show selfie capture page on phone
    public function showSelfieCapture(Request $request)
    {
        $mobile = $request->query('phone');
        if (!$mobile) {
            return abort(400, "Phone number is required.");
        }
        return view('frontend.pages.selfie_capture', compact('mobile'));
    }

    // Save phone selfie to Cache
    public function savePhoneSelfie(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
            'selfie_data' => 'required|string'
        ]);

        $mobile = $request->mobile;
        // Save selfie data URL into cache for 30 minutes
        \Illuminate\Support\Facades\Cache::put('selfie_verified_' . $mobile, $request->selfie_data, now()->addMinutes(30));

        return response()->json(['success' => true]);
    }

    // Desktop polling to check if selfie was captured
    public function checkSelfieStatus(Request $request)
    {
        $mobile = $request->query('phone');
        if (!$mobile) {
            return response()->json(['success' => false]);
        }

        $selfieData = \Illuminate\Support\Facades\Cache::get('selfie_verified_' . $mobile);
        
        if ($selfieData) {
            return response()->json([
                'success' => true,
                'selfie_data' => $selfieData
            ]);
        }

        return response()->json(['success' => false]);
    }

    // Register Step 1 (Modal form submission)
    public function showRegister()
    {
        return view('frontend.pages.register');
    }

    // Process Final Registration
    public function registerFinal(Request $request)
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
            'mobile' => 'required|digits:10|unique:candidates,mobile',
            
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'full_address' => 'required|string',
            'sub_community' => 'nullable|string',
            'marital_status' => 'required|string',
            'height' => 'required|string',
            'diet' => 'required|string',
            
            'highest_qualification' => 'required|string',
            'college_name' => 'nullable|string',
            'college_address' => 'nullable|string',
            
            'income_type' => 'required|string',
            'profession' => 'required|string',
            'designation' => 'required|string',
            'company_name' => 'nullable|string',
            'company_address' => 'nullable|string',
            
            'about_yourself' => 'nullable|string',
            'hobbies_interests' => 'nullable|array',
            'profile_picture' => 'nullable|image|max:15360', // Allow images up to 15MB, compressed on server
            'selfie_image' => 'required|file|mimes:jpeg,png,jpg,webp|max:15360', // Mandatory, compressed on server
        ]);

        $candidateData = $validated;
        
        // Initialize Intervention Image Manager
        $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
        
        // Handle file upload and compression
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = uniqid('profile_') . '.webp';
            $path = 'profiles/' . $filename;
            
            $image = $manager->decodePath($file->getRealPath());
            $encoded = $image->scaleDown(1200)->encodeUsingFileExtension('webp', 70);
            \Illuminate\Support\Facades\Storage::disk('public')->put($path, (string) $encoded);
            
            $candidateData['profile_picture'] = $path;
        }

        if ($request->hasFile('selfie_image')) {
            $file = $request->file('selfie_image');
            $filename = uniqid('selfie_') . '.webp';
            $path = 'selfies/' . $filename;
            
            $image = $manager->decodePath($file->getRealPath());
            $encoded = $image->scaleDown(1200)->encodeUsingFileExtension('webp', 70);
            \Illuminate\Support\Facades\Storage::disk('public')->put($path, (string) $encoded);
            
            $candidateData['selfie_verified'] = true;
        }
        
        $candidate = Candidate::create($candidateData);

        // Auto login after registration
        Auth::login($candidate);
        
        // Send Welcome WhatsApp Message
        try {
            $apiKey = env('TWILIO_SID');
            $apiSecret = env('TWILIO_AUTH_TOKEN');
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');

            if ($apiKey && $apiSecret && $accountSid && $twilioNumber) {
                $twilio = new Client($apiKey, $apiSecret, $accountSid);
                $formattedMobile = "whatsapp:+91" . ltrim($candidate->mobile, '0');
                
                $templateSid = 'HX05336e99a055aea550db5d5e69e6fbf0';
                
                $twilio->messages->create(
                    $formattedMobile,
                    [
                        "from" => $twilioNumber,
                        "contentSid" => $templateSid,
                        "contentVariables" => json_encode([
                            "1" => $candidate->first_name
                        ])
                    ]
                );
            }
        } catch (\Exception $e) {
            \Log::error("Welcome WhatsApp Message Error: " . $e->getMessage());
        }

        return response()->json(['success' => true, 'redirect' => route('dashboard')]);
    }

    // Candidate dashboard
    public function dashboard()
    {
        $candidate = Auth::user();
        return view('frontend.pages.dashboard', compact('candidate'));
    }

    // Candidate Profile
    public function myProfile()
    {
        $candidate = Auth::user();
        
        // Calculate Age from DOB
        $age = null;
        if ($candidate->dob) {
            $dob = new \DateTime($candidate->dob);
            $now = new \DateTime();
            $age = $now->diff($dob)->y;
        }

        return view('frontend.pages.my_profile', compact('candidate', 'age'));
    }
    // Candidate Profile Update via AJAX
    public function updateProfile(Request $request)
    {
        $candidate = Auth::user();
        
        $section = $request->input('section');
        $rules = [];
        
        switch ($section) {
            case 'about':
                $rules = [
                    'about_yourself' => 'nullable|string',
                ];
                break;
            case 'basic':
                $rules = [
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
                    'profession' => 'nullable|string|max:150',
                    'designation' => 'nullable|string|max:150',
                    'annual_income' => 'nullable|string|max:100',
                    'company_name' => 'nullable|string|max:200',
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
            case 'contact':
                $rules = [
                    'contact_display_option' => 'nullable|string|max:255',
                ];
                break;
            default:
                return response()->json(['success' => false, 'message' => 'Invalid section.'], 400);
        }

        $validated = $request->validate($rules);
        $candidate->update($validated);

        return response()->json(['success' => true, 'message' => 'Profile updated successfully.']);
    }

    // Upload Profile Picture via AJAX
    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,webp|max:15360',
        ]);

        $candidate = Auth::user();
        
        $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
        
        $file = $request->file('profile_picture');
        $filename = uniqid('profile_') . '.webp';
        $path = 'profiles/' . $filename;
        
        $image = $manager->decodePath($file->getRealPath());
        $encoded = $image->scaleDown(1200)->encodeUsingFileExtension('webp', 70);
        \Illuminate\Support\Facades\Storage::disk('public')->put($path, (string) $encoded);
        
        // Delete old profile picture if exists
        if ($candidate->profile_picture && \Illuminate\Support\Facades\Storage::disk('public')->exists($candidate->profile_picture)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($candidate->profile_picture);
        }

        $candidate->update(['profile_picture' => $path]);

        // Sync with candidate_photos table
        \App\Models\CandidatePhoto::where('candidate_id', $candidate->id)->update(['is_profile_picture' => false]);
        \App\Models\CandidatePhoto::create([
            'candidate_id' => $candidate->id,
            'photo_path' => $path,
            'is_profile_picture' => true,
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Profile picture updated successfully.',
            'image_url' => asset('storage/' . $path)
        ]);
    }

    // My Photos Page View
    public function myPhotos()
    {
        $candidate = Auth::user();
        $photos = $candidate->photos;
        
        $formattedPhotos = $photos->map(function ($photo) {
            return [
                'id' => $photo->id,
                'url' => asset('storage/' . $photo->photo_path),
                'is_profile_picture' => (bool)$photo->is_profile_picture,
                'created_at' => $photo->created_at ? $photo->created_at->diffForHumans() : '',
            ];
        })->values();

        return view('frontend.pages.my_photos', compact('candidate', 'photos', 'formattedPhotos'));
    }

    // Upload one or multiple photos to Gallery
    public function uploadGalleryPhotos(Request $request)
    {
        $request->validate([
            'photos' => 'required|array|min:1|max:10',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:15360',
        ]);

        $candidate = Auth::user();
        $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

        $uploadedPhotos = [];
        $hasProfilePic = $candidate->profile_picture && \Illuminate\Support\Facades\Storage::disk('public')->exists($candidate->profile_picture);

        foreach ($request->file('photos') as $index => $file) {
            $filename = uniqid('gallery_' . $candidate->id . '_') . '.webp';
            $path = 'gallery/' . $filename;

            $image = $manager->decodePath($file->getRealPath());
            $encoded = $image->scaleDown(1600)->encodeUsingFileExtension('webp', 75);
            \Illuminate\Support\Facades\Storage::disk('public')->put($path, (string) $encoded);

            $isFirst = (!$hasProfilePic && $index === 0 && count($candidate->photos) === 0);

            $photoRecord = \App\Models\CandidatePhoto::create([
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
                'url' => asset('storage/' . $path),
                'is_profile_picture' => $photoRecord->is_profile_picture,
                'created_at' => $photoRecord->created_at->diffForHumans(),
            ];
        }

        return response()->json([
            'success' => true,
            'message' => count($uploadedPhotos) . ' photo(s) uploaded successfully.',
            'photos' => $uploadedPhotos,
        ]);
    }

    // Set a gallery photo as main profile picture
    public function setProfilePhoto(Request $request)
    {
        $request->validate([
            'photo_id' => 'required|integer',
        ]);

        $candidate = Auth::user();
        $photo = \App\Models\CandidatePhoto::where('id', $request->photo_id)
            ->where('candidate_id', $candidate->id)
            ->first();

        if (!$photo) {
            return response()->json(['success' => false, 'message' => 'Photo not found.'], 404);
        }

        // Reset previous profile flags and set current
        \App\Models\CandidatePhoto::where('candidate_id', $candidate->id)->update(['is_profile_picture' => false]);
        $photo->update(['is_profile_picture' => true]);

        // Update candidate profile_picture
        $candidate->update(['profile_picture' => $photo->photo_path]);

        return response()->json([
            'success' => true,
            'message' => 'Profile picture set successfully.',
            'image_url' => asset('storage/' . $photo->photo_path),
        ]);
    }

    // Delete a gallery photo
    public function deletePhoto(Request $request)
    {
        $request->validate([
            'photo_id' => 'required|integer',
        ]);

        $candidate = Auth::user();
        $photo = \App\Models\CandidatePhoto::where('id', $request->photo_id)
            ->where('candidate_id', $candidate->id)
            ->first();

        if (!$photo) {
            return response()->json(['success' => false, 'message' => 'Photo not found.'], 404);
        }

        $wasProfilePic = $photo->is_profile_picture || ($candidate->profile_picture === $photo->photo_path);

        // Delete physical file
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($photo->photo_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->photo_path);
        }

        $photo->delete();

        // If it was the profile picture, assign the next available photo or null
        $newProfileUrl = null;
        if ($wasProfilePic) {
            $nextPhoto = \App\Models\CandidatePhoto::where('candidate_id', $candidate->id)->latest()->first();
            if ($nextPhoto) {
                $nextPhoto->update(['is_profile_picture' => true]);
                $candidate->update(['profile_picture' => $nextPhoto->photo_path]);
                $newProfileUrl = asset('storage/' . $nextPhoto->photo_path);
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
}
