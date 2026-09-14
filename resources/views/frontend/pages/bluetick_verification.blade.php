@extends('frontend.layouts.auth_app')

@section('title', 'Blue Tick Verification | Rani Matrimonial')

@section('content')
<div class="relative pt-6 pb-20" x-data="blueTickManager({
    candidate: @js($candidate),
    existingBluetick: @js($existingBluetick),
    isVerified: @js((bool) ($candidate->is_bluetick_verified || ($existingBluetick && (int)$existingBluetick->is_accept === 1))),
    isPending: @js((bool) ($existingBluetick && (int)$existingBluetick->is_accept === 0)),
    isRejected: @js((bool) ($existingBluetick && (int)$existingBluetick->is_accept === 2)),
    registeredAadhar: @js($candidate->aadhar_number ?? '')
})">
    <!-- Background Image -->
    <div class="fixed inset-0 z-0 bg-cover bg-top bg-no-repeat" style="background-image: url('{{ asset('img/hero.png') }}');"></div>
    
    <!-- Maroon/Gold Gradient Overlay -->
    <div class="fixed inset-0 z-0 bg-gradient-to-t from-rani-dark/85 via-rani-primary-dark/45 to-rani-primary-dark/25"></div>
    
    <!-- Floating Sweet Gestures (Hearts) -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none heart-container opacity-40">
        <div class="heart-floating delay-1"></div>
        <div class="heart-floating heart-maroon delay-2"></div>
        <div class="heart-floating delay-3"></div>
        <div class="heart-floating heart-maroon delay-4"></div>
        <div class="heart-floating delay-5"></div>
    </div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Navigation Breadcrumb -->
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-white/80 hover:text-white text-xs font-semibold bg-black/30 hover:bg-black/50 px-4 py-2 rounded-xl backdrop-blur-sm transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Dashboard
            </a>
            <div class="inline-flex items-center gap-1.5 bg-rani-gold/20 text-rani-gold border border-rani-gold/40 text-xs font-bold px-3 py-1.5 rounded-full">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span>Trust & Safety Verification</span>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border border-white/60 overflow-hidden relative">
            <!-- Accent Top Bar -->
            <div class="h-2.5 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold"></div>

            <div class="p-6 sm:p-10">
                
                <!-- Header -->
                <div class="text-center max-w-2xl mx-auto mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 mb-3 shadow-xs border border-blue-200">
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold font-serif text-rani-primary-dark">Blue Tick Verification</h1>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1.5">Verify your Government-issued Aadhaar Card to obtain the coveted verified badge, build trust, and receive up to 2x more matches.</p>
                </div>

                <!-- Status Alerts -->
                <template x-if="isVerified">
                    <div class="p-6 rounded-2xl bg-gradient-to-r from-blue-50 via-sky-50 to-indigo-50 border border-blue-200 mb-8 flex flex-col sm:flex-row items-center gap-5 text-center sm:text-left">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-blue-600 via-sky-500 to-sky-400 text-white flex items-center justify-center shrink-0 shadow-md border-2 border-white">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-base font-bold text-blue-900 flex items-center gap-1.5 justify-center sm:justify-start">
                                <span>Your Profile is Blue Tick Verified!</span>
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </h3>
                            <p class="text-xs text-blue-700 mt-1">Your Aadhaar verification has been successfully approved by Rani Matrimonial Admin. Your profile badge is active across all matchmaking lists.</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition-colors">
                            Return to Dashboard
                        </a>
                    </div>
                </template>

                <template x-if="isPending && !isVerified">
                    <div class="p-6 rounded-2xl bg-gradient-to-r from-amber-50 via-yellow-50 to-amber-50 border border-amber-200 mb-8 flex flex-col sm:flex-row items-center gap-5 text-center sm:text-left">
                        <div class="w-14 h-14 rounded-full bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-md">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-base font-bold text-amber-900">Verification Under Review (24-48 Hours)</h3>
                            <p class="text-xs text-amber-700 mt-1">We have received your Aadhaar card documents. Our security verification team is currently verifying the details. You will receive an SMS and WhatsApp notification once approved.</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-amber-700 hover:bg-amber-800 text-white font-bold text-xs shadow-xs transition-colors">
                            Back to Dashboard
                        </a>
                    </div>
                </template>

                <template x-if="isRejected && !isVerified">
                    <div class="p-5 rounded-2xl bg-red-50 border border-red-200 mb-8 flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-red-500 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-red-900">Previous Verification Request Rejected</h4>
                            <p class="text-xs text-red-700 mt-0.5" x-text="existingBluetick && existingBluetick.admin_notes ? existingBluetick.admin_notes : 'The uploaded Aadhaar photos were unclear or did not match the registered profile details. Please re-submit valid documents below.'"></p>
                        </div>
                    </div>
                </template>

                <!-- Verification Form (Visible when not verified or when rejected) -->
                <div x-show="!isVerified && !isPending" class="space-y-8">
                    
                    <!-- Progress Steps Indicator -->
                    <div class="flex items-center justify-between relative max-w-xl mx-auto mb-8">
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-gray-200 z-0"></div>
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-gradient-to-r from-rani-primary to-blue-600 transition-all duration-500 z-0"
                             :style="'width: ' + (step === 1 ? '15%' : (step === 2 ? '50%' : '100%'))"></div>
                        
                        <!-- Step 1 Dot -->
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs transition-all shadow-sm"
                                 :class="step >= 1 && aadharVerified ? 'bg-emerald-500 text-white' : (step === 1 ? 'bg-rani-primary text-white ring-4 ring-rani-primary/20' : 'bg-gray-200 text-gray-600')">
                                <template x-if="aadharVerified">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </template>
                                <template x-if="!aadharVerified"><span>1</span></template>
                            </div>
                            <span class="text-[11px] font-semibold text-gray-700 mt-1.5">Aadhaar No.</span>
                        </div>

                        <!-- Step 2 Dot -->
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs transition-all shadow-sm"
                                 :class="frontPhoto ? 'bg-emerald-500 text-white' : (step === 2 ? 'bg-rani-primary text-white ring-4 ring-rani-primary/20' : 'bg-gray-200 text-gray-600')">
                                <template x-if="frontPhoto">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </template>
                                <template x-if="!frontPhoto"><span>2</span></template>
                            </div>
                            <span class="text-[11px] font-semibold text-gray-700 mt-1.5">Front Side</span>
                        </div>

                        <!-- Step 3 Dot -->
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs transition-all shadow-sm"
                                 :class="backPhoto ? 'bg-emerald-500 text-white' : (step === 3 ? 'bg-rani-primary text-white ring-4 ring-rani-primary/20' : 'bg-gray-200 text-gray-600')">
                                <template x-if="backPhoto">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </template>
                                <template x-if="!backPhoto"><span>3</span></template>
                            </div>
                            <span class="text-[11px] font-semibold text-gray-700 mt-1.5">Back Side</span>
                        </div>
                    </div>

                    <!-- STEP 1: Enter & Validate Aadhaar Number -->
                    <div class="p-6 rounded-2xl border transition-all"
                         :class="step === 1 ? 'border-rani-primary/40 bg-white shadow-md' : 'border-gray-200 bg-gray-50/50 opacity-95'">
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-rani-primary text-white flex items-center justify-center text-xs font-bold">1</span>
                                <h3 class="font-bold text-gray-800 text-sm sm:text-base">Enter 12-Digit Aadhaar Number</h3>
                            </div>
                            <template x-if="aadharVerified">
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    Matched
                                </span>
                            </template>
                        </div>

                        <div class="max-w-md">
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Aadhaar Card Number</label>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <input type="text" 
                                       x-model="aadharInput" 
                                       @input="formatAadharInput($event)"
                                       :disabled="aadharVerified"
                                       placeholder="XXXX XXXX XXXX" 
                                       maxlength="14" 
                                       class="flex-1 px-4 py-2.5 rounded-xl border text-sm font-mono tracking-widest text-gray-800 focus:outline-none focus:ring-2 focus:ring-rani-primary focus:border-transparent bg-white shadow-xs"
                                       :class="aadharError ? 'border-red-400 bg-red-50/30' : 'border-gray-300'">
                                
                                <template x-if="!aadharVerified">
                                    <button type="button" 
                                            @click="verifyAadharNumber()" 
                                            :disabled="validatingAadhar || cleanAadhar.length !== 12"
                                            class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:shadow-md text-white text-xs font-bold transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-1.5 shrink-0">
                                        <template x-if="validatingAadhar">
                                            <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        </template>
                                        <span>Verify Aadhaar</span>
                                    </button>
                                </template>

                                <template x-if="aadharVerified">
                                    <button type="button" 
                                            @click="resetAadhar()" 
                                            class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition-colors shrink-0">
                                        Change
                                    </button>
                                </template>
                            </div>

                            <!-- Error alert -->
                            <div x-show="aadharError" x-cloak class="mt-2 text-xs font-medium text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                <span x-text="aadharError"></span>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: Front Side Photo Upload -->
                    <div x-show="aadharVerified" x-transition class="p-6 rounded-2xl border transition-all"
                         :class="step === 2 ? 'border-rani-primary/40 bg-white shadow-md' : 'border-gray-200 bg-gray-50/50 opacity-95'">
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-rani-primary text-white flex items-center justify-center text-xs font-bold">2</span>
                                <h3 class="font-bold text-gray-800 text-sm sm:text-base">Upload Front Side of Aadhaar Card</h3>
                            </div>
                            <template x-if="frontPhoto">
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    Front Uploaded
                                </span>
                            </template>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                            <!-- Dropzone -->
                            <div>
                                <label for="front_photo_input" class="border-2 border-dashed border-gray-300 hover:border-rani-primary rounded-2xl p-6 flex flex-col items-center justify-center text-center cursor-pointer bg-gray-50 hover:bg-rani-primary/5 transition-all group">
                                    <svg class="w-10 h-10 text-gray-400 group-hover:text-rani-primary transition-colors mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class="text-xs font-bold text-gray-700 group-hover:text-rani-primary">Click to upload Aadhaar Front Image</p>
                                    <p class="text-[11px] text-gray-400 mt-1">JPEG, PNG, WebP up to 10MB</p>
                                    <input id="front_photo_input" type="file" accept="image/*" class="hidden" @change="handleFrontUpload($event)">
                                </label>
                            </div>

                            <!-- Preview -->
                            <div>
                                <template x-if="frontPreview">
                                    <div class="relative rounded-2xl overflow-hidden border-2 border-rani-gold/40 shadow-sm bg-gray-100 max-h-48 flex items-center justify-center group">
                                        <img :src="frontPreview" alt="Front Aadhaar" class="max-h-48 w-full object-contain">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                            <button type="button" @click="frontPhoto = null; frontPreview = null;" class="p-2 bg-red-600 text-white rounded-full hover:bg-red-700 shadow-md">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="!frontPreview">
                                    <div class="h-44 border border-dashed border-gray-200 rounded-2xl flex flex-col items-center justify-center text-gray-400 text-xs text-center p-4">
                                        <svg class="w-8 h-8 text-gray-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Front Image Preview will appear here
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: Back Side Photo Upload -->
                    <div x-show="frontPhoto" x-transition class="p-6 rounded-2xl border transition-all"
                         :class="step === 3 ? 'border-rani-primary/40 bg-white shadow-md' : 'border-gray-200 bg-gray-50/50 opacity-95'">
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-rani-primary text-white flex items-center justify-center text-xs font-bold">3</span>
                                <h3 class="font-bold text-gray-800 text-sm sm:text-base">Upload Back Side of Aadhaar Card</h3>
                            </div>
                            <template x-if="backPhoto">
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    Back Uploaded
                                </span>
                            </template>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                            <!-- Dropzone -->
                            <div>
                                <label for="back_photo_input" class="border-2 border-dashed border-gray-300 hover:border-rani-primary rounded-2xl p-6 flex flex-col items-center justify-center text-center cursor-pointer bg-gray-50 hover:bg-rani-primary/5 transition-all group">
                                    <svg class="w-10 h-10 text-gray-400 group-hover:text-rani-primary transition-colors mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class="text-xs font-bold text-gray-700 group-hover:text-rani-primary">Click to upload Aadhaar Back Image</p>
                                    <p class="text-[11px] text-gray-400 mt-1">JPEG, PNG, WebP up to 10MB</p>
                                    <input id="back_photo_input" type="file" accept="image/*" class="hidden" @change="handleBackUpload($event)">
                                </label>
                            </div>

                            <!-- Preview -->
                            <div>
                                <template x-if="backPreview">
                                    <div class="relative rounded-2xl overflow-hidden border-2 border-rani-gold/40 shadow-sm bg-gray-100 max-h-48 flex items-center justify-center group">
                                        <img :src="backPreview" alt="Back Aadhaar" class="max-h-48 w-full object-contain">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                            <button type="button" @click="backPhoto = null; backPreview = null;" class="p-2 bg-red-600 text-white rounded-full hover:bg-red-700 shadow-md">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="!backPreview">
                                    <div class="h-44 border border-dashed border-gray-200 rounded-2xl flex flex-col items-center justify-center text-gray-400 text-xs text-center p-4">
                                        <svg class="w-8 h-8 text-gray-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Back Image Preview will appear here
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Final Submission Button -->
                    <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-xs text-gray-500 max-w-md">
                            🔒 <strong>Privacy Assured:</strong> Your Aadhaar details and card photos are strictly encrypted and used solely for identity verification purposes by authorized personnel.
                        </p>

                        <button type="button" 
                                @click="submitVerificationForm()" 
                                :disabled="!aadharVerified || !frontPhoto || !backPhoto || submitting"
                                class="w-full sm:w-auto px-8 py-3.5 rounded-2xl bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:shadow-xl text-white font-bold text-sm transition-all disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                            <template x-if="submitting">
                                <svg class="animate-spin w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </template>
                            <span>Submit for Blue Tick Verification</span>
                        </button>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

<!-- Blue Tick Verification Alpine Component Script -->
<script>
function blueTickManager(initialData) {
    return {
        candidate: initialData.candidate || {},
        existingBluetick: initialData.existingBluetick || null,
        isVerified: initialData.isVerified || false,
        isPending: initialData.isPending || false,
        isRejected: initialData.isRejected || false,
        registeredAadhar: initialData.registeredAadhar || '',

        step: 1,
        aadharInput: '',
        aadharVerified: false,
        validatingAadhar: false,
        aadharError: '',

        frontPhoto: null,
        frontPreview: null,

        backPhoto: null,
        backPreview: null,

        submitting: false,

        init() {
            if (this.registeredAadhar) {
                const clean = String(this.registeredAadhar).replace(/\D/g, '');
                if (clean.length === 12) {
                    this.aadharInput = clean.replace(/(\d{4})(\d{4})(\d{4})/, '$1 $2 $3');
                }
            }
        },

        get cleanAadhar() {
            return (this.aadharInput || '').replace(/\D/g, '');
        },

        formatAadharInput(e) {
            this.aadharError = '';
            let val = e.target.value.replace(/\D/g, '');
            if (val.length > 12) val = val.substring(0, 12);
            
            // Format as XXXX XXXX XXXX
            let formatted = '';
            for (let i = 0; i < val.length; i++) {
                if (i > 0 && i % 4 === 0) formatted += ' ';
                formatted += val[i];
            }
            this.aadharInput = formatted;
        },

        resetAadhar() {
            this.aadharVerified = false;
            this.step = 1;
            this.frontPhoto = null;
            this.frontPreview = null;
            this.backPhoto = null;
            this.backPreview = null;
        },

        async verifyAadharNumber() {
            if (this.cleanAadhar.length !== 12) {
                this.aadharError = 'Please enter a valid 12-digit Aadhaar number.';
                return;
            }

            this.validatingAadhar = true;
            this.aadharError = '';

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

            try {
                const res = await fetch('{{ route("bluetick.validate-aadhar") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        aadhar_number: this.cleanAadhar
                    })
                });

                let data;
                try {
                    data = await res.json();
                } catch (e) {
                    data = { success: false, message: 'Unexpected server response.' };
                }

                if (res.ok && data.success) {
                    this.aadharVerified = true;
                    this.step = 2;
                    Swal.fire({
                        icon: 'success',
                        title: 'Aadhaar Matched!',
                        text: 'Aadhaar number verified with your profile. Please proceed to upload front & back photos.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2500,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title' }
                    });
                } else {
                    this.aadharError = data.message || 'Aadhaar number does not match your registered profile Aadhaar number.';
                }
            } catch (err) {
                console.error(err);
                this.aadharError = 'Unable to verify Aadhaar number. Please try again.';
            } finally {
                this.validatingAadhar = false;
            }
        },

        async handleFrontUpload(e) {
            const file = e.target.files[0];
            if (!file) return;

            try {
                const compressed = await this.compressImage(file);
                this.frontPhoto = compressed.file;
                this.frontPreview = compressed.dataUrl;
                this.step = 3;
            } catch (err) {
                console.error(err);
                const reader = new FileReader();
                reader.onload = (re) => {
                    this.frontPhoto = file;
                    this.frontPreview = re.target.result;
                    this.step = 3;
                };
                reader.readAsDataURL(file);
            }
        },

        async handleBackUpload(e) {
            const file = e.target.files[0];
            if (!file) return;

            try {
                const compressed = await this.compressImage(file);
                this.backPhoto = compressed.file;
                this.backPreview = compressed.dataUrl;
            } catch (err) {
                console.error(err);
                const reader = new FileReader();
                reader.onload = (re) => {
                    this.backPhoto = file;
                    this.backPreview = re.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        compressImage(file, maxWidth = 1600, maxHeight = 1600, quality = 0.85) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = (event) => {
                    const img = new Image();
                    img.src = event.target.result;
                    img.onload = () => {
                        let width = img.width;
                        let height = img.height;

                        if (width > height) {
                            if (width > maxWidth) {
                                height = Math.round((height * maxWidth) / width);
                                width = maxWidth;
                            }
                        } else {
                            if (height > maxHeight) {
                                width = Math.round((width * maxHeight) / height);
                                height = maxHeight;
                            }
                        }

                        const canvas = document.createElement('canvas');
                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);

                        canvas.toBlob((blob) => {
                            if (blob) {
                                const compressedFile = new File([blob], 'aadhar_doc.jpg', {
                                    type: 'image/jpeg',
                                    lastModified: Date.now()
                                });
                                resolve({ file: compressedFile, dataUrl: canvas.toDataURL('image/jpeg', quality) });
                            } else {
                                resolve({ file: file, dataUrl: event.target.result });
                            }
                        }, 'image/jpeg', quality);
                    };
                    img.onerror = (err) => reject(err);
                };
                reader.onerror = (err) => reject(err);
            });
        },

        async submitVerificationForm() {
            if (!this.aadharVerified || !this.frontPhoto || !this.backPhoto) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Form',
                    text: 'Please verify your Aadhaar number and upload both front & back photos of your Aadhaar card.',
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                });
                return;
            }

            this.submitting = true;

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

            const formData = new FormData();
            formData.append('_token', token);
            formData.append('aadhar_number', this.cleanAadhar);
            formData.append('aadhar_photo_front', this.frontPhoto);
            formData.append('aadhar_photo_back', this.backPhoto);

            try {
                const res = await fetch('{{ route("bluetick.submit") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                let data;
                const resText = await res.text();
                try {
                    data = JSON.parse(resText);
                } catch (e) {
                    console.error('Non-JSON response:', resText);
                    data = { success: false, message: 'Server error (' + res.status + '). Please try again or refresh.' };
                }

                if (res.ok && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Verification Request Submitted!',
                        html: '<div class="text-center py-2">' +
                              '<p class="text-sm text-gray-200 mb-3">' + data.message + '</p>' +
                              '<div class="bg-black/30 p-3 rounded-xl border border-rani-gold/30 text-xs text-rani-gold text-left space-y-1">' +
                              '<p>✓ Aadhaar Document Received</p>' +
                              '<p>✓ Admin Verification In-Progress</p>' +
                              '<p>✓ 24-48 Hours Verification Timeline</p>' +
                              '</div>' +
                              '</div>',
                        confirmButtonText: 'Back to Dashboard',
                        customClass: {
                            popup: 'rani-swal-popup',
                            title: 'rani-swal-title',
                            confirmButton: 'rani-swal-confirm'
                        }
                    }).then(() => {
                        window.location.href = '{{ route("dashboard") }}';
                    });
                } else {
                    let errMsg = data.message || 'Unable to submit verification request.';
                    if (data.errors) {
                        const firstKey = Object.keys(data.errors)[0];
                        if (firstKey && data.errors[firstKey].length) {
                            errMsg = data.errors[firstKey][0];
                        }
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Error',
                        text: errMsg,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                }
            } catch (err) {
                console.error('Submit error:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Something went wrong. Please check your connection and try again.',
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                });
            } finally {
                this.submitting = false;
            }
        }
    };
}
</script>
@endsection
