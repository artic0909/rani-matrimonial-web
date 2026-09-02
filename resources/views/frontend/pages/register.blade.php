@extends('frontend.layouts.app')

@section('title', 'Register - Ranimatrimonial')

@section('content')

<div class="min-h-screen bg-gray-50 py-12" x-data="registrationForm()">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Form Container -->
        <div class="bg-white rounded-[30px] shadow-2xl overflow-hidden p-8 relative border border-gray-100">
            
            <!-- Header -->
            <div class="text-center relative mb-8">
                <button type="button" @click="prevStep()" x-show="step > 1" class="absolute left-0 top-1 text-gray-400 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                
                <h3 class="text-2xl font-serif font-bold text-[#5C0A0A]">Registration</h3>
                <p class="text-xs text-gray-500 mt-1">Step <span x-text="step"></span> of 14</p>
                
                <!-- Progress Bar -->
                <div class="w-full bg-gray-100 h-1 mt-4 rounded-full overflow-hidden">
                    <div class="bg-[#5C0A0A] h-full transition-all duration-300" :style="'width: ' + ((step / 14) * 100) + '%'"></div>
                </div>
            </div>

            <!-- Form Body -->
            <div>
                <form id="unifiedRegForm" action="{{ route('register.final') }}" method="POST" enctype="multipart/form-data" @submit.prevent="submitForm">
                    @csrf
                    
                    <!-- Step 1: Profile For -->
                    <div x-show="step === 1" x-transition.opacity>
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        </div>

                        <h4 class="text-sm text-gray-600 mb-3 text-center">This Profile is for</h4>
                        <div class="flex flex-wrap justify-center gap-3 mb-6">
                            <template x-for="type in ['Myself', 'My Son', 'My Daughter', 'My Brother', 'My Sister', 'My Friend']">
                                <button type="button" @click="setProfileFor(type)" 
                                        :class="formData.profile_for === type ? 'border-[#5C0A0A] bg-[#5C0A0A] text-white font-medium' : 'border-gray-200 text-gray-600 hover:border-[#5C0A0A] hover:text-[#5C0A0A]'"
                                        class="py-2 px-5 rounded-full border text-sm transition-all duration-200 shadow-sm">
                                    <span x-text="type"></span>
                                </button>
                            </template>
                        </div>
                        <div class="mt-8">
                            <button type="button" :disabled="!formData.profile_for" @click="nextStep" class="w-full text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center" :class="formData.profile_for ? 'bg-[#5C0A0A] hover:bg-red-900' : 'bg-gray-300 cursor-not-allowed'">Continue</button>
                        </div>
                    </div>

                    <!-- Step 2: Gender -->
                    <div x-show="step === 2" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-4.418 0-8 3.582-8 8h16c0-4.418-3.582-8-8-8z"></path></svg>
                            </div>
                        </div>
                        <h4 class="text-sm text-gray-600 mb-3 text-center mt-6">Gender</h4>
                        <div class="flex justify-center gap-4">
                            <button type="button" @click="setGender('Male')" 
                                :class="formData.gender === 'Male' ? 'border-[#5C0A0A] bg-red-50' : 'border-gray-200 hover:border-[#5C0A0A] hover:bg-gray-50'"
                                class="w-32 py-3 rounded-xl border-2 flex flex-col items-center justify-center transition-all duration-200">
                                <span class="text-2xl mb-1">👨</span>
                                <span class="text-sm font-medium text-gray-700">Male</span>
                            </button>
                            <button type="button" @click="setGender('Female')" 
                                :class="formData.gender === 'Female' ? 'border-[#5C0A0A] bg-red-50' : 'border-gray-200 hover:border-[#5C0A0A] hover:bg-gray-50'"
                                class="w-32 py-3 rounded-xl border-2 flex flex-col items-center justify-center transition-all duration-200">
                                <span class="text-2xl mb-1">👩</span>
                                <span class="text-sm font-medium text-gray-700">Female</span>
                            </button>
                        </div>
                        <div class="mt-8">
                            <button type="button" :disabled="!formData.gender" @click="nextStep" class="w-full text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center" :class="formData.gender ? 'bg-[#5C0A0A] hover:bg-red-900' : 'bg-gray-300 cursor-not-allowed'">Continue</button>
                        </div>
                    </div>

                    <!-- Step 3: Name -->
                    <div x-show="step === 3" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">First Name</label>
                                <input type="text" name="first_name" x-model="formData.first_name" required class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Middle Name (Optional)</label>
                                <input type="text" name="middle_name" x-model="formData.middle_name" class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Last Name</label>
                                <input type="text" name="last_name" x-model="formData.last_name" required class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                        </div>
                        <div class="mt-8">
                            <button type="button" @click="nextStep" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">Continue</button>
                        </div>
                    </div>

                    <!-- Step 4: DOB -->
                    <div x-show="step === 4" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z"/></svg>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Date of Birth</label>
                            <div class="grid grid-cols-3 gap-3">
                                <input type="text" x-model="formData.dob_day" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="DD" maxlength="2" class="w-full px-4 py-3 rounded-lg bg-white border border-gray-300 focus:ring-2 focus:ring-[#5C0A0A] focus:border-transparent outline-none text-center">
                                <input type="text" x-model="formData.dob_month" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="MM" maxlength="2" class="w-full px-4 py-3 rounded-lg bg-white border border-gray-300 focus:ring-2 focus:ring-[#5C0A0A] focus:border-transparent outline-none text-center">
                                <input type="text" x-model="formData.dob_year" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="YYYY" maxlength="4" class="w-full px-4 py-3 rounded-lg bg-white border border-gray-300 focus:ring-2 focus:ring-[#5C0A0A] focus:border-transparent outline-none text-center">
                            </div>
                            <!-- Hidden input for final submission -->
                            <input type="hidden" name="dob" :value="formData.dob_year + '-' + formData.dob_month + '-' + formData.dob_day">
                        </div>
                        <div class="mt-8">
                            <button type="button" @click="nextStep" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">Continue</button>
                        </div>
                    </div>

                    <!-- Step 5: Religion -->
                    <div x-show="step === 5" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Religion</label>
                                <select name="religion" x-model="formData.religion" class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                                    <option value="" disabled>Select Religion</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Muslim">Muslim</option>
                                    <option value="Christian">Christian</option>
                                    <option value="Sikh">Sikh</option>
                                    <option value="Jain">Jain</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Community</label>
                                <select name="community" x-model="formData.community" class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                                    <option value="" disabled>Select Community</option>
                                    <option value="Brahmin">Brahmin</option>
                                    <option value="Rajput">Rajput</option>
                                    <option value="Baniya">Baniya</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-8">
                            <button type="button" @click="nextStep" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">Continue</button>
                        </div>
                    </div>

                    <!-- Step 6: Contact Info -->
                    <div x-show="step === 6" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Email ID</label>
                                <input type="email" name="email" x-model="formData.email" required placeholder="name@example.com" class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Mobile Number</label>
                                <input type="tel" name="mobile" x-model="formData.mobile" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="10-digit mobile number" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#5C0A0A] focus:border-transparent outline-none" maxlength="10">
                            </div>
                        </div>
                        <div class="mt-8">
                            <button type="button" @click="nextStep" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">Continue</button>
                        </div>
                    </div>

                    <!-- Step 7: Location -->
                    <div x-show="step === 7" x-transition.opacity style="display: none;">
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

                    <!-- Step 8: Marital Status -->
                    <div x-show="step === 8" x-transition.opacity style="display: none;">
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

                    <!-- Step 9: Qualification -->
                    <div x-show="step === 9" x-transition.opacity style="display: none;">
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

                    <!-- Step 10: Income -->
                    <div x-show="step === 10" x-transition.opacity style="display: none;">
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

                    <!-- Step 11: Work details -->
                    <div x-show="step === 11" x-transition.opacity style="display: none;">
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

                    <!-- Step 12: About Yourself & Hobbies -->
                    <div x-show="step === 12" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">About Yourself</label>
                                <textarea name="about_yourself" x-model="formData.about_yourself" required rows="4" placeholder="Write something about yourself..." class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm text-gray-600 mb-3">Hobbies & Interest</label>
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="hobby in ['Creative', 'Fun', 'Fitness', 'Music', 'Travel', 'Reading', 'Cooking', 'Photography', 'Sports', 'Art']">
                                        <label class="px-4 py-2 border rounded-full cursor-pointer transition-colors" :class="{'border-[#5C0A0A] bg-[#5C0A0A] text-white': formData.hobbies.includes(hobby), 'border-gray-200 text-gray-700 hover:border-[#5C0A0A]': !formData.hobbies.includes(hobby)}">
                                            <input type="checkbox" name="hobbies_interests[]" :value="hobby" x-model="formData.hobbies" class="hidden">
                                            <span class="text-xs font-medium" x-text="hobby"></span>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8">
                            <button type="button" @click="nextStep" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">Continue</button>
                        </div>
                    </div>

                    <!-- Step 13: OTP Verification -->
                    <div x-show="step === 13" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                        </div>
                        <h4 class="text-center font-medium text-gray-700 mb-2">Verify Mobile Number</h4>
                        <p class="text-sm text-gray-500 text-center mb-6">Enter the 4-digit code sent to <span class="font-bold text-gray-700" x-text="formData.mobile"></span></p>
                        
                        <div class="flex justify-center gap-3 mb-6" x-data="{ otpInputs: ['', '', '', ''] }">
                            <template x-for="(digit, index) in otpInputs" :key="index">
                                <input type="text" maxlength="1" x-model="otpInputs[index]" @input="handleOtpInput($event, index); otp = otpInputs.join('')" class="w-14 h-14 text-center text-2xl font-bold bg-[#EAF1FF] rounded-lg border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none otp-input">
                            </template>
                        </div>
                        
                        <div class="mt-8">
                            <button type="button" @click="verifyOtp" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center flex justify-center items-center">
                                <span x-show="!isVerifyingOtp">Verify & Continue</span>
                                <svg x-show="isVerifyingOtp" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display:none;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 14: Selfie & Profile Picture -->
                    <div x-show="step === 14" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                        </div>

                        <h4 class="text-center font-medium text-gray-700 mb-4">Security Verification</h4>
                        
                        <!-- Upload standard profile picture too -->
                        <div class="mb-6">
                            <label class="block text-sm text-gray-600 mb-2 font-medium">Upload Profile Picture</label>
                            <div class="border-2 border-dashed border-gray-300 bg-[#EAF1FF] rounded-xl p-4 text-center cursor-pointer" @click="$refs.fileInput.click()">
                                <template x-if="!imagePreview">
                                    <p class="text-sm text-gray-600">Click to upload (PNG, JPG)</p>
                                </template>
                                <template x-if="imagePreview">
                                    <div class="w-20 h-20 mx-auto rounded-full overflow-hidden border-2 border-[#5C0A0A]">
                                        <img :src="imagePreview" class="w-full h-full object-cover">
                                    </div>
                                </template>
                            </div>
                            <input type="file" name="profile_picture" x-ref="fileInput" @change="handleFileUpload" class="hidden" accept="image/*">
                        </div>

                        <label class="block text-sm text-gray-600 mb-2 font-medium">Live Selfie Verification</label>
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
                            <button type="submit" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-bold py-3.5 rounded-full shadow-md transition-all text-center relative">
                                <span x-show="!isSubmitting">Create Profile</span>
                                <span x-show="isSubmitting" style="display: none;">Creating...</span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function registrationForm() {
        return {
            step: 1,
            formData: {
                profile_for: '', gender: '', first_name: '', middle_name: '', last_name: '', 
                dob_day: '', dob_month: '', dob_year: '', religion: '', community: '', living_in: '', 
                email: '', mobile: '',
                state: '', city: '', sub_community: '',
                marital_status: '', height: '', diet: '',
                highest_qualification: '', college_name: '', college_address: '',
                profession: '', designation: '', income_type: '', company_name: '', company_address: '',
                about_yourself: '',
                hobbies: []
            },
            otp: '',
            imagePreview: null,
            isVerifyingOtp: false,
            isSelfieVerified: false,
            isSubmitting: false,
            
            setProfileFor(val) {
                this.formData.profile_for = val;
            },
            setGender(val) {
                this.formData.gender = val;
                setTimeout(() => this.nextStep(), 300);
            },
            nextStep() {
                // If moving from 12 to 13 (OTP), trigger OTP send using the mobile typed in step 6
                if (this.step === 12) {
                    if(!this.formData.mobile) {
                        alert("Mobile number is required");
                        this.step = 6;
                        return;
                    }
                    this.sendOtp();
                }
                
                if (this.step < 14) this.step++;
            },
            prevStep() {
                if (this.step > 1) this.step--;
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
                        mobile: this.formData.mobile
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
                if(this.otp.length !== 4) return alert("Please enter the 4-digit OTP.");
                
                this.isVerifyingOtp = true;
                fetch('/api/verify-registration-otp', {
                    method: 'POST',
                    body: JSON.stringify({ otp: this.otp }),
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value }
                })
                .then(res => res.json())
                .then(data => {
                    this.isVerifyingOtp = false;
                    if(data.success) {
                        this.nextStep();
                    } else {
                        alert(data.message || 'Invalid OTP');
                        const inputs = document.querySelectorAll('.otp-input');
                        inputs.forEach(i => i.value = '');
                        this.otp = '';
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
                if(this.isSubmitting) return;
                this.isSubmitting = true;
                
                const form = document.getElementById('unifiedRegForm');
                const formData = new FormData(form);
                
                // Add Alpine JS data state that aren't inputs (if any)
                // We mapped all inputs with x-model and name="", so FormData has them.
                
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
                    this.isSubmitting = false;
                    if(data.success && data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        alert(data.message || 'An error occurred during registration.');
                    }
                })
                .catch(error => {
                    this.isSubmitting = false;
                    alert('Submission failed. Please check validation or try again.');
                });
            }
        }
    }
</script>
@endsection
