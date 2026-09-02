@extends('frontend.layouts.app')

@section('title', 'Complete Your Profile - Ranimatrimonial')

@section('content')

<div class="min-h-screen bg-gray-50 py-12" x-data="completeProfileForm()">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Form Container -->
        <div class="bg-white rounded-[30px] shadow-2xl overflow-hidden p-8 relative border border-gray-100">
            
            <!-- Header -->
            <div class="text-center relative mb-8">
                <button type="button" @click="prevStep()" x-show="step > 5" class="absolute left-0 top-1 text-gray-400 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                
                <h3 class="text-2xl font-serif font-bold text-[#5C0A0A]">Registration</h3>
                <p class="text-xs text-gray-500 mt-1">Step <span x-text="step"></span> of 14</p>
            </div>

            <!-- Form Body -->
            <div>
                <form id="finalRegForm" action="{{ route('register.final') }}" method="POST" enctype="multipart/form-data" @submit.prevent="submitForm">
                    @csrf
                    
                    <!-- Step 5: Location -->
                    <div x-show="step === 5" x-transition.opacity>
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">State</label>
                                <input type="text" name="state" x-model="formData.state" required class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">City</label>
                                <input type="text" name="city" x-model="formData.city" required class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Sub-community (Optional)</label>
                                <input type="text" name="sub_community" x-model="formData.sub_community" class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                        </div>
                        <div class="mt-8">
                            <button type="button" @click="nextStep" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">Continue</button>
                        </div>
                    </div>

                    <!-- Step 6: Marital Status -->
                    <div x-show="step === 6" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Marital Status</label>
                                <select name="marital_status" x-model="formData.marital_status" required class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                                    <option value="" disabled>Select Status</option>
                                    <option value="Never Married">Never Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Height</label>
                                <select name="height" x-model="formData.height" required class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                                    <option value="" disabled>Select Height</option>
                                    <option value="5ft 0in">5ft 0in</option>
                                    <option value="5ft 2in">5ft 2in</option>
                                    <option value="5ft 4in">5ft 4in</option>
                                    <option value="5ft 6in">5ft 6in</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Diet</label>
                                <select name="diet" x-model="formData.diet" required class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                                    <option value="" disabled>Select Diet</option>
                                    <option value="Veg">Vegetarian</option>
                                    <option value="Non-Veg">Non-Vegetarian</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-8">
                            <button type="button" @click="nextStep" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">Continue</button>
                        </div>
                    </div>

                    <!-- Step 7: Qualification -->
                    <div x-show="step === 7" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Highest Qualification</label>
                                <select name="highest_qualification" x-model="formData.highest_qualification" required class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                                    <option value="" disabled>Select Qualification</option>
                                    <option value="B.E / B.Tech">B.E / B.Tech</option>
                                    <option value="B.A">B.A</option>
                                    <option value="MBA">MBA</option>
                                    <option value="PhD">PhD</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">College Name</label>
                                <input type="text" name="college_name" x-model="formData.college_name" class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">College Address</label>
                                <input type="text" name="college_address" x-model="formData.college_address" class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                        </div>
                        <div class="mt-8">
                            <button type="button" @click="nextStep" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">Continue</button>
                        </div>
                    </div>

                    <!-- Step 8: Income -->
                    <div x-show="step === 8" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Income</label>
                                <select name="income_type" x-model="formData.income_type" required class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                                    <option value="" disabled>Select Income Range</option>
                                    <option value="Monthly: Under 20k">Monthly: Under 20k</option>
                                    <option value="Monthly: 20k - 50k">Monthly: 20k - 50k</option>
                                    <option value="Yearly: 5L - 10L">Yearly: 5L - 10L</option>
                                    <option value="Yearly: 10L+">Yearly: 10L+</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-8">
                            <button type="button" @click="nextStep" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">Continue</button>
                        </div>
                    </div>

                    <!-- Step 9: Work details -->
                    <div x-show="step === 9" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Your Profession</label>
                                <input type="text" name="profession" x-model="formData.profession" required class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Your Designation</label>
                                <input type="text" name="designation" x-model="formData.designation" required class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Company Name</label>
                                <input type="text" name="company_name" x-model="formData.company_name" class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Company Address</label>
                                <input type="text" name="company_address" x-model="formData.company_address" class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                        </div>
                        <div class="mt-8">
                            <button type="button" @click="nextStep" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">Continue</button>
                        </div>
                    </div>

                    <!-- Step 10: About Yourself -->
                    <div x-show="step === 10" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">About Yourself</label>
                                <textarea name="about_yourself" x-model="formData.about_yourself" required rows="5" placeholder="Write something about yourself..." class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none"></textarea>
                            </div>
                        </div>
                        <div class="mt-8">
                            <button type="button" @click="nextStep" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">Continue</button>
                        </div>
                    </div>

                    <!-- Step 11: OTP Verification -->
                    <div x-show="step === 11" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                        </div>

                        <h4 class="text-center font-medium text-gray-700 mb-6">Enter the OTP sent to your Mobile</h4>
                        <div class="flex justify-center gap-3 mb-6" x-data="{ otp: ['', '', '', ''] }">
                            <template x-for="(digit, index) in otp" :key="index">
                                <input type="text" maxlength="1" x-model="otp[index]" @input="handleOtpInput($event, index)" class="w-14 h-14 text-center text-2xl font-bold bg-[#EAF1FF] rounded-lg border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none otp-input">
                            </template>
                        </div>
                        
                        <div class="mt-8">
                            <button type="button" @click="verifyOtp" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center flex justify-center items-center">
                                <span x-show="!isVerifyingOtp">Verify OTP</span>
                                <svg x-show="isVerifyingOtp" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display:none;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 12: Profile Picture Upload -->
                    <div x-show="step === 12" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>

                        <div class="border-2 border-dashed border-gray-300 bg-[#EAF1FF] rounded-xl p-8 text-center cursor-pointer" @click="$refs.fileInput.click()">
                            <template x-if="!imagePreview">
                                <div>
                                    <p class="text-sm text-gray-600 font-medium">Click to upload Profile Picture</p>
                                    <p class="text-xs text-gray-500 mt-1">PNG or JPG</p>
                                </div>
                            </template>
                            <template x-if="imagePreview">
                                <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-2 border-[#5C0A0A]">
                                    <img :src="imagePreview" class="w-full h-full object-cover">
                                </div>
                            </template>
                        </div>
                        <input type="file" name="profile_picture" x-ref="fileInput" @change="handleFileUpload" class="hidden" accept="image/*">
                        
                        <div class="mt-8">
                            <button type="button" @click="nextStep" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">Continue</button>
                        </div>
                    </div>

                    <!-- Step 13: Hobbies & Interest -->
                    <div x-show="step === 13" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3 justify-center">
                            <template x-for="hobby in ['Creative', 'Fun', 'Fitness', 'Music', 'Travel', 'Reading', 'Cooking', 'Photography', 'Sports', 'Art']">
                                <label class="px-4 py-2 border rounded-full cursor-pointer transition-colors" :class="{'border-[#5C0A0A] bg-[#5C0A0A] text-white': formData.hobbies.includes(hobby), 'border-gray-200 text-gray-700 hover:border-[#5C0A0A]': !formData.hobbies.includes(hobby)}">
                                    <input type="checkbox" name="hobbies_interests[]" :value="hobby" x-model="formData.hobbies" class="hidden">
                                    <span class="text-sm font-medium" x-text="hobby"></span>
                                </label>
                            </template>
                        </div>
                        
                        <div class="mt-8">
                            <button type="button" @click="nextStep" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">Continue</button>
                        </div>
                    </div>

                    <!-- Step 14: Selfie Verification -->
                    <div x-show="step === 14" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                        </div>

                        <h4 class="text-center font-medium text-gray-700 mb-4">Verify Your Profile</h4>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <button type="button" @click="startCamera" class="flex-1 py-3 px-4 rounded-lg border-2 border-gray-200 text-gray-700 hover:border-[#5C0A0A] font-medium flex flex-col items-center">
                                <svg class="w-6 h-6 mb-2 text-[#5C0A0A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Take Selfie (PC)
                            </button>
                            <button type="button" @click="mockPhoneSelfie" class="flex-1 py-3 px-4 rounded-lg border-2 border-gray-200 text-gray-700 hover:border-[#5C0A0A] font-medium flex flex-col items-center">
                                <svg class="w-6 h-6 mb-2 text-[#5C0A0A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                Take Selfie (Phone)
                            </button>
                        </div>

                        <div x-show="isCameraOpen" class="mt-6 border-2 border-[#5C0A0A] rounded-xl overflow-hidden relative bg-black" style="display: none;">
                            <video x-ref="videoElement" autoplay playsinline class="w-full h-auto"></video>
                            <button type="button" @click="takeSelfie" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-white text-[#5C0A0A] rounded-full p-4 shadow-xl hover:bg-gray-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </button>
                        </div>
                        <canvas x-ref="canvasElement" class="hidden"></canvas>

                        <div x-show="isSelfieVerified" class="mt-4 p-3 bg-green-50 text-green-700 rounded-lg text-center font-medium" style="display: none;">
                            Selfie Verified!
                        </div>
                        
                        <div class="mt-8">
                            <button type="submit" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-bold py-3.5 rounded-full shadow-md transition-all text-center">
                                Create Profile
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function completeProfileForm() {
        return {
            step: 5,
            formData: {
                state: '', city: '', sub_community: '',
                marital_status: '', height: '', diet: '',
                highest_qualification: '', college_name: '', college_address: '',
                profession: '', designation: '', income_type: '', company_name: '', company_address: '',
                about_yourself: '',
                hobbies: []
            },
            imagePreview: null,
            isVerifyingOtp: false,
            isSelfieVerified: false,
            
            nextStep() {
                // If moving from 10 to 11 (OTP), trigger OTP send
                if (this.step === 10) {
                    this.sendOtp();
                }
                
                if (this.step < 14) this.step++;
            },
            prevStep() {
                if (this.step > 5) this.step--;
            },
            handleFileUpload(e) {
                const file = e.target.files[0];
                if (file) {
                    this.imagePreview = URL.createObjectURL(file);
                }
            },
            sendOtp() {
                fetch('/api/send-registration-otp', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
                    body: JSON.stringify({
                        mobile: '{{ session('registration_phase_1')['mobile'] ?? '' }}'
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if(!data.success) {
                        alert(data.message || 'Error sending OTP');
                    }
                })
                .catch(err => console.error(err));
            },
            verifyOtp() {
                const enteredOtp = this.otp.join('');
                if(enteredOtp.length !== 4) return alert("Please enter the 4-digit OTP.");
                
                this.isVerifyingOtp = true;
                fetch('/api/verify-registration-otp', {
                    method: 'POST',
                    body: JSON.stringify({ otp: enteredOtp }),
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value }
                })
                .then(res => res.json())
                .then(data => {
                    this.isVerifyingOtp = false;
                    if(data.success) {
                        this.nextStep();
                    } else {
                        alert(data.message || 'Invalid OTP');
                        this.otp = ['', '', '', ''];
                    }
                })
                .catch(err => {
                    this.isVerifyingOtp = false;
                    alert('Error verifying OTP');
                });
            },
            handleOtpInput(e, index) {
                const inputs = document.querySelectorAll('.otp-input');
                if (e.target.value !== '' && index < 3) {
                    inputs[index + 1].focus();
                }
            },
            
            isCameraOpen: false,
            stream: null,
            selfieDataUrl: null,
            
            startCamera() {
                this.isCameraOpen = true;
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(stream => {
                        this.stream = stream;
                        this.$refs.videoElement.srcObject = stream;
                    })
                    .catch(err => {
                        console.error("Camera access denied", err);
                        alert("Camera access required for PC selfie.");
                        this.isCameraOpen = false;
                    });
            },
            takeSelfie() {
                const video = this.$refs.videoElement;
                const canvas = this.$refs.canvasElement;
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                this.selfieDataUrl = canvas.toDataURL('image/jpeg');
                this.stream.getTracks().forEach(track => track.stop());
                this.isCameraOpen = false;
                this.isSelfieVerified = true;
            },
            mockPhoneSelfie() {
                alert("A secure link has been sent to your phone! Please complete the verification there.");
                this.isSelfieVerified = true;
            },
            submitForm(e) {
                const form = document.getElementById('finalRegForm');
                const formData = new FormData(form);
                if (this.selfieDataUrl) {
                    const byteString = atob(this.selfieDataUrl.split(',')[1]);
                    const ab = new ArrayBuffer(byteString.length);
                    const ia = new Uint8Array(ab);
                    for (let i = 0; i < byteString.length; i++) {
                        ia[i] = byteString.charCodeAt(i);
                    }
                    const blob = new Blob([ab], { type: 'image/jpeg' });
                    formData.append('selfie_image', blob, 'selfie.jpg');
                }
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success && data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        alert(data.message || 'An error occurred');
                    }
                })
                .catch(error => {
                    alert('Submission failed. Please try again.');
                });
            }
        }
    }
</script>
@endsection
