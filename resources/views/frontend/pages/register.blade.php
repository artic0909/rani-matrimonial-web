@extends('frontend.layouts.app')

@section('title', 'Register - Ranimatrimonial')

@section('content')

<!-- Theme-based Styling Overrides -->
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
    .theme-input {
        background-color: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(212, 175, 55, 0.4); /* rani-gold with opacity */
        transition: all 0.3s ease;
        color: #4a0404; /* rani-primary-dark */
    }
    .theme-input:focus {
        background-color: rgba(255, 255, 255, 0.95);
        border-color: #D4AF37; /* rani-gold */
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        outline: none;
    }
    .theme-input::placeholder {
        color: rgba(92, 10, 10, 0.5);
    }
    .theme-btn {
        background: linear-gradient(to right, #D4AF37, #C59B27);
        color: #4a0404;
        border: none;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    .theme-btn:hover:not(:disabled) {
        background: linear-gradient(to right, #C59B27, #D4AF37);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(212, 175, 55, 0.4);
    }
    .theme-btn:disabled {
        background: rgba(255, 255, 255, 0.3);
        color: rgba(255, 255, 255, 0.5);
        cursor: not-allowed;
    }
    
    /* Option buttons (Myself, Gender, etc) */
    .option-btn {
        background: rgba(255, 255, 255, 0.5);
        border: 1px solid rgba(212, 175, 55, 0.3);
        color: #4a0404;
        transition: all 0.3s ease;
    }
    .option-btn:hover {
        background: rgba(255, 255, 255, 0.8);
        border-color: #D4AF37;
    }
    .option-btn.selected {
        background: #D4AF37;
        color: #4a0404;
        border-color: #D4AF37;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
    }
    
    /* Step Indicator */
    .step-dot {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        transition: all 0.4s ease;
    }
    .step-dot.active {
        background: #D4AF37;
        color: #4a0404;
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.6);
        transform: scale(1.2);
    }
    .step-dot.completed {
        background: rgba(212, 175, 55, 0.5);
        color: #fff;
    }
    .step-dot.pending {
        background: rgba(255, 255, 255, 0.2);
        color: rgba(255, 255, 255, 0.6);
    }
</style>

<div class="min-h-screen py-12 relative flex items-center justify-center overflow-hidden" x-data="registrationForm()">
    
    <!-- Background with blur -->
    <div class="absolute inset-0 z-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('img/hero.png') }}'); filter: blur(8px) brightness(0.7);"></div>
    
    <!-- Theme Overlay (Maroon Gradient) -->
    <div class="absolute inset-0 z-0 bg-gradient-to-br from-[#4a0404]/80 via-[#5C0A0A]/60 to-[#D4AF37]/30 mix-blend-multiply"></div>

    <!-- Floating Hearts (Theme colors) -->
    <div class="heart-container z-0 opacity-40">
        <div class="heart-floating delay-1" style="color: #D4AF37;"></div>
        <div class="heart-floating heart-maroon delay-2"></div>
        <div class="heart-floating delay-3" style="color: #D4AF37;"></div>
        <div class="heart-floating heart-maroon delay-4"></div>
        <div class="heart-floating delay-5" style="color: #D4AF37;"></div>
        <div class="heart-floating heart-maroon delay-1" style="left: 20%; animation-delay: 7s;"></div>
        <div class="heart-floating delay-2" style="left: 40%; animation-delay: 9s; color: #D4AF37;"></div>
        <div class="heart-floating heart-maroon delay-3" style="left: 60%; animation-delay: 2s;"></div>
        <div class="heart-floating delay-4" style="left: 80%; animation-delay: 14s; color: #D4AF37;"></div>
    </div>

    <div class="w-full max-w-2xl mx-auto px-4 sm:px-6 relative z-10 py-12 mt-10">
        
        <!-- Welcome Text -->
        <div class="text-center mb-8">
            <h2 class="text-3xl md:text-5xl font-serif font-bold text-white mb-2 drop-shadow-lg">
                Join <span class="text-rani-gold">Ranimatrimonial</span>
            </h2>
            <p class="text-rani-gold-light font-light text-lg">Your perfect match is waiting.</p>
        </div>

        <!-- Form Container -->
        <div class="glass-card rounded-[30px] p-8 md:p-10 relative overflow-hidden">
            
            <!-- Step Tracker Indicator (Visual Highlight) -->
            <div class="mb-10 relative">
                <!-- Back Button -->
                <button type="button" @click="prevStep()" x-show="step > 1" class="absolute left-0 top-0 text-white hover:text-rani-gold transition-colors z-20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                
                <h3 class="text-center text-rani-gold text-sm font-bold uppercase tracking-widest mb-4">Step <span x-text="step"></span> of 14</h3>
                
                <!-- Dots line -->
                <div class="flex justify-between items-center relative max-w-md mx-auto z-10 px-6">
                    <div class="absolute left-6 right-6 top-1/2 h-0.5 bg-white/20 -z-10 -translate-y-1/2"></div>
                    <div class="absolute left-6 top-1/2 h-0.5 bg-rani-gold -z-10 -translate-y-1/2 transition-all duration-500 ease-out" :style="'width: ' + ((step - 1) / 13 * 100 * 0.88) + '%'"></div>
                    
                    <!-- Just showing 5 milestone dots to not clutter -->
                    <div class="step-dot" :class="step >= 1 ? (step === 1 ? 'active' : 'completed') : 'pending'">1</div>
                    <div class="step-dot" :class="step >= 4 ? (step === 4 ? 'active' : 'completed') : 'pending'">4</div>
                    <div class="step-dot" :class="step >= 8 ? (step === 8 ? 'active' : 'completed') : 'pending'">8</div>
                    <div class="step-dot" :class="step >= 12 ? (step === 12 ? 'active' : 'completed') : 'pending'">12</div>
                    <div class="step-dot" :class="step >= 14 ? (step === 14 ? 'active' : 'completed') : 'pending'">14</div>
                </div>
            </div>

            <!-- Form Body -->
            <div class="relative z-10 min-h-[320px] flex flex-col justify-center">
                <form id="unifiedRegForm" action="{{ route('register.final') }}" method="POST" enctype="multipart/form-data" @submit.prevent="submitForm">
                    @csrf
                    
                    <!-- Step 1: Profile For -->
                    <div x-show="step === 1" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-12" 
                         x-transition:enter-end="opacity-100 translate-x-0" 
                          
                          
                         >
                        
                        <div class="flex justify-center mb-6">
                            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center text-rani-gold border border-rani-gold/50 shadow-[0_0_15px_rgba(212,175,55,0.3)]">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                        </div>

                        <h4 class="text-2xl font-serif text-white mb-8 text-center text-shadow-sm">This Profile is for</h4>
                        <div class="flex flex-wrap justify-center gap-3 mb-8">
                            <template x-for="type in ['Myself', 'My Son', 'My Daughter', 'My Brother', 'My Sister', 'My Friend']">
                                <button type="button" @click="setProfileFor(type)" 
                                        :class="formData.profile_for === type ? 'selected' : ''"
                                        class="option-btn py-2.5 px-6 rounded-full font-medium text-sm backdrop-blur-sm">
                                    <span x-text="type"></span>
                                </button>
                            </template>
                        </div>
                        <div class="mt-4">
                            <button type="button" :disabled="!formData.profile_for" @click="nextStep" class="w-full theme-btn py-4 rounded-full text-lg">Continue</button>
                        </div>
                    </div>

                    <!-- Step 2: Gender -->
                    <div x-show="step === 2" style="display: none;"
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-12" 
                         x-transition:enter-end="opacity-100 translate-x-0" 
                          
                          
                         >
                        
                        <div class="flex justify-center mb-6">
                            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center text-rani-gold border border-rani-gold/50 shadow-[0_0_15px_rgba(212,175,55,0.3)]">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-4.418 0-8 3.582-8 8h16c0-4.418-3.582-8-8-8z"></path></svg>
                            </div>
                        </div>
                        <h4 class="text-2xl font-serif text-white mb-8 text-center text-shadow-sm">Select Gender</h4>
                        <div class="flex justify-center gap-6 mb-8">
                            <button type="button" @click="setGender('Male')" 
                                :class="formData.gender === 'Male' ? 'selected' : ''"
                                class="option-btn w-36 py-6 rounded-2xl flex flex-col items-center justify-center backdrop-blur-sm group">
                                <span class="text-4xl mb-3 group-hover:scale-110 transition-transform">👨</span>
                                <span class="text-base font-bold">Groom</span>
                            </button>
                            <button type="button" @click="setGender('Female')" 
                                :class="formData.gender === 'Female' ? 'selected' : ''"
                                class="option-btn w-36 py-6 rounded-2xl flex flex-col items-center justify-center backdrop-blur-sm group">
                                <span class="text-4xl mb-3 group-hover:scale-110 transition-transform">👩</span>
                                <span class="text-base font-bold">Bride</span>
                            </button>
                        </div>
                        <div class="mt-4">
                            <button type="button" :disabled="!formData.gender" @click="nextStep" class="w-full theme-btn py-4 rounded-full text-lg">Continue</button>
                        </div>
                    </div>

                    <!-- Step 3: Name -->
                    <div x-show="step === 3" style="display: none;"
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-12" 
                         x-transition:enter-end="opacity-100 translate-x-0" 
                          
                          
                         >
                        
                        <h4 class="text-2xl font-serif text-white mb-8 text-center text-shadow-sm">Personal Details</h4>
                        <div class="space-y-5 mb-8">
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">First Name</label>
                                <input type="text" name="first_name" x-model="formData.first_name" required class="w-full px-5 py-3.5 rounded-xl theme-input" placeholder="e.g. Rahul">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Middle Name (Optional)</label>
                                <input type="text" name="middle_name" x-model="formData.middle_name" class="w-full px-5 py-3.5 rounded-xl theme-input">
                            </div>
                            <!-- Last Name & Aadhar Number Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-5">
                                <div>
                                    <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Last Name</label>
                                    <input type="text" x-model="formData.last_name" placeholder="e.g. Sharma" 
                                        class="w-full px-5 py-3.5 rounded-xl theme-input">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Aadhar Number</label>
                                    <input type="text" x-model="formData.aadhar_number" placeholder="12-digit Aadhar Number" maxlength="12"
                                        class="w-full px-5 py-3.5 rounded-xl theme-input"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" @click="nextStep" :disabled="!formData.first_name || !formData.last_name || !formData.aadhar_number" class="w-full theme-btn py-4 rounded-full text-lg">Continue</button>
                        </div>
                    </div>

                    <!-- Step 4: DOB -->
                    <div x-show="step === 4" style="display: none;"
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-12" 
                         x-transition:enter-end="opacity-100 translate-x-0" 
                          
                          
                         >
                        
                        <h4 class="text-2xl font-serif text-white mb-8 text-center text-shadow-sm">Date of Birth</h4>
                        <div class="mb-8">
                            <div class="flex justify-center gap-3">
                                <div class="w-20">
                                    <input type="tel" x-model="formData.dob_day" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="DD" maxlength="2" class="w-full px-2 py-4 rounded-xl theme-input font-bold text-center text-xl">
                                </div>
                                <div class="text-white/80 text-3xl font-light self-center">/</div>
                                <div class="w-20">
                                    <input type="tel" x-model="formData.dob_month" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="MM" maxlength="2" class="w-full px-2 py-4 rounded-xl theme-input font-bold text-center text-xl">
                                </div>
                                <div class="text-white/80 text-3xl font-light self-center">/</div>
                                <div class="w-24">
                                    <input type="tel" x-model="formData.dob_year" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="YYYY" maxlength="4" class="w-full px-2 py-4 rounded-xl theme-input font-bold text-center text-xl">
                                </div>
                            </div>
                            <input type="hidden" name="dob" :value="formData.dob_year + '-' + formData.dob_month + '-' + formData.dob_day">
                        </div>
                        <div class="mt-4">
                            <button type="button" @click="nextStep" :disabled="!(formData.dob_day && formData.dob_month && formData.dob_year)" class="w-full theme-btn py-4 rounded-full text-lg">Continue</button>
                        </div>
                    </div>

                    <!-- Step 5: Religion -->
                    <div x-show="step === 5" style="display: none;"
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-12" 
                         x-transition:enter-end="opacity-100 translate-x-0" 
                          
                          
                         >
                         
                        <h4 class="text-2xl font-serif text-white mb-8 text-center text-shadow-sm">Religion & Community</h4>
                        <div class="space-y-5 mb-8">
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Religion</label>
                                <select name="religion" x-model="formData.religion" class="w-full px-5 py-3.5 rounded-xl theme-input">
                                    <option value="" disabled>Select Religion</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Muslim">Muslim</option>
                                    <option value="Christian">Christian</option>
                                    <option value="Sikh">Sikh</option>
                                    <option value="Jain">Jain</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Community</label>
                                <select name="community" x-model="formData.community" class="w-full px-5 py-3.5 rounded-xl theme-input">
                                    <option value="" disabled>Select Community</option>
                                    <option value="Brahmin">Brahmin</option>
                                    <option value="Rajput">Rajput</option>
                                    <option value="Baniya">Baniya</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" @click="nextStep" :disabled="!(formData.religion && formData.community)" class="w-full theme-btn py-4 rounded-full text-lg">Continue</button>
                        </div>
                    </div>

                    <!-- Step 6: Contact Info -->
                    <div x-show="step === 6" style="display: none;"
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-12" 
                         x-transition:enter-end="opacity-100 translate-x-0" 
                          
                          
                         >
                         
                        <h4 class="text-2xl font-serif text-white mb-8 text-center text-shadow-sm">Contact Information</h4>
                        <div class="space-y-5 mb-8">
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Email ID</label>
                                <input type="email" name="email" x-model="formData.email" required placeholder="name@example.com" class="w-full px-5 py-3.5 rounded-xl theme-input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Mobile Number</label>
                                <div class="flex shadow-sm rounded-xl overflow-hidden">
                                    <span class="inline-flex items-center px-4 bg-white/50 text-[#4a0404] font-bold border border-rani-gold/40 border-r-0">+91</span>
                                    <input type="tel" name="mobile" x-model="formData.mobile" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="10-digit number" class="flex-1 min-w-0 block w-full px-5 py-3.5 theme-input !rounded-l-none" maxlength="10">
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" @click="nextStep" :disabled="!(formData.email && formData.mobile)" class="w-full theme-btn py-4 rounded-full text-lg">Continue</button>
                        </div>
                    </div>

                    <!-- Step 7: Location -->
                    <div x-show="step === 7" style="display: none;"
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-12" 
                         x-transition:enter-end="opacity-100 translate-x-0" 
                          
                          
                         >
                         
                        <h4 class="text-2xl font-serif text-white mb-8 text-center text-shadow-sm">Location</h4>
                        
                        <!-- Country Row -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Country (Living In)</label>
                            <select x-model="formData.country" 
                                class="w-full px-5 py-3.5 rounded-xl theme-input appearance-none">
                                <option value="">Select Country</option>
                                <option value="India">India</option>
                                <option value="USA">USA</option>
                                <option value="UK">UK</option>
                                <option value="Canada">Canada</option>
                                <option value="Australia">Australia</option>
                                <option value="UAE">UAE</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- State & City Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">State</label>
                                <select x-model="formData.state" class="w-full px-5 py-3.5 rounded-xl theme-input appearance-none">
                                    <option value="">Select State</option>
                                    <option value="West Bengal">West Bengal</option>
                                    <option value="Maharashtra">Maharashtra</option>
                                    <option value="Delhi">Delhi</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">City</label>
                                <input type="text" x-model="formData.city" placeholder="e.g. Kolkata" 
                                    class="w-full px-5 py-3.5 rounded-xl theme-input">
                            </div>
                        </div>

                        <!-- Full Address -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Full Address</label>
                            <textarea x-model="formData.full_address" placeholder="Enter your complete residential address" rows="3"
                                class="w-full px-5 py-3.5 rounded-xl theme-input resize-none"></textarea>
                        </div>

                        <!-- Sub-community -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Sub-community (Optional)</label>
                            <input type="text" name="sub_community" x-model="formData.sub_community" class="w-full px-5 py-3.5 rounded-xl theme-input">
                        </div>

                        <div class="mt-8">
                            <button type="button" @click="nextStep" :disabled="!(formData.country && formData.state && formData.city && formData.full_address)" class="w-full theme-btn py-4 rounded-full text-lg">Continue</button>
                        </div>
                    </div>

                    <!-- Step 8: Marital Status -->
                    <div x-show="step === 8" style="display: none;"
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-12" 
                         x-transition:enter-end="opacity-100 translate-x-0" 
                          
                          
                         >
                         
                        <h4 class="text-2xl font-serif text-white mb-8 text-center text-shadow-sm">Physical & Diet</h4>
                        <div class="space-y-5 mb-8">
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Marital Status</label>
                                <select name="marital_status" x-model="formData.marital_status" required class="w-full px-5 py-3.5 rounded-xl theme-input">
                                    <option value="" disabled>Select Status</option>
                                    <option value="Never Married">Never Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Height</label>
                                <select name="height" x-model="formData.height" required class="w-full px-5 py-3.5 rounded-xl theme-input">
                                    <option value="" disabled>Select Height</option>
                                    <option value="5ft 0in">5ft 0in</option>
                                    <option value="5ft 2in">5ft 2in</option>
                                    <option value="5ft 4in">5ft 4in</option>
                                    <option value="5ft 6in">5ft 6in</option>
                                    <option value="5ft 8in">5ft 8in</option>
                                    <option value="5ft 10in">5ft 10in</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Diet</label>
                                <select name="diet" x-model="formData.diet" required class="w-full px-5 py-3.5 rounded-xl theme-input">
                                    <option value="" disabled>Select Diet</option>
                                    <option value="Veg">Vegetarian</option>
                                    <option value="Non-Veg">Non-Vegetarian</option>
                                    <option value="Eggetarian">Eggetarian</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" @click="nextStep" :disabled="!(formData.marital_status && formData.height && formData.diet)" class="w-full theme-btn py-4 rounded-full text-lg">Continue</button>
                        </div>
                    </div>

                    <!-- Step 9: Qualification -->
                    <div x-show="step === 9" style="display: none;"
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-12" 
                         x-transition:enter-end="opacity-100 translate-x-0" 
                          
                          
                         >
                         
                        <h4 class="text-2xl font-serif text-white mb-8 text-center text-shadow-sm">Education</h4>
                        <div class="space-y-5 mb-8">
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Highest Qualification</label>
                                <select name="highest_qualification" x-model="formData.highest_qualification" required class="w-full px-5 py-3.5 rounded-xl theme-input">
                                    <option value="" disabled>Select Qualification</option>
                                    <option value="B.E / B.Tech">B.E / B.Tech</option>
                                    <option value="B.A">B.A</option>
                                    <option value="MBA">MBA</option>
                                    <option value="PhD">PhD</option>
                                    <option value="Medical">Medical</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">College Name</label>
                                <input type="text" name="college_name" x-model="formData.college_name" class="w-full px-5 py-3.5 rounded-xl theme-input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">College Address</label>
                                <input type="text" name="college_address" x-model="formData.college_address" class="w-full px-5 py-3.5 rounded-xl theme-input">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" @click="nextStep" :disabled="!formData.highest_qualification" class="w-full theme-btn py-4 rounded-full text-lg">Continue</button>
                        </div>
                    </div>

                    <!-- Step 10: Income -->
                    <div x-show="step === 10" style="display: none;"
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-12" 
                         x-transition:enter-end="opacity-100 translate-x-0" 
                          
                          
                         >
                         
                        <h4 class="text-2xl font-serif text-white mb-8 text-center text-shadow-sm">Income Details</h4>
                        <div class="space-y-5 mb-8">
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Income</label>
                                <select name="income_type" x-model="formData.income_type" required class="w-full px-5 py-3.5 rounded-xl theme-input">
                                    <option value="" disabled>Select Income Range</option>
                                    <option value="Monthly: Under 20k">Monthly: Under 20k</option>
                                    <option value="Monthly: 20k - 50k">Monthly: 20k - 50k</option>
                                    <option value="Yearly: 5L - 10L">Yearly: 5L - 10L</option>
                                    <option value="Yearly: 10L+">Yearly: 10L+</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" @click="nextStep" :disabled="!formData.income_type" class="w-full theme-btn py-4 rounded-full text-lg">Continue</button>
                        </div>
                    </div>

                    <!-- Step 11: Work details -->
                    <div x-show="step === 11" style="display: none;"
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-12" 
                         x-transition:enter-end="opacity-100 translate-x-0" 
                          
                          
                         >
                         
                        <h4 class="text-2xl font-serif text-white mb-8 text-center text-shadow-sm">Career Details</h4>
                        <div class="space-y-5 mb-8">
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Your Profession</label>
                                <input type="text" name="profession" x-model="formData.profession" required class="w-full px-5 py-3.5 rounded-xl theme-input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Your Designation</label>
                                <input type="text" name="designation" x-model="formData.designation" required class="w-full px-5 py-3.5 rounded-xl theme-input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Company Name</label>
                                <input type="text" name="company_name" x-model="formData.company_name" class="w-full px-5 py-3.5 rounded-xl theme-input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Company Address</label>
                                <input type="text" name="company_address" x-model="formData.company_address" class="w-full px-5 py-3.5 rounded-xl theme-input">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" @click="nextStep" :disabled="!(formData.profession && formData.designation)" class="w-full theme-btn py-4 rounded-full text-lg">Continue</button>
                        </div>
                    </div>

                    <!-- Step 12: About Yourself & Hobbies -->
                    <div x-show="step === 12" style="display: none;"
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-12" 
                         x-transition:enter-end="opacity-100 translate-x-0" 
                          
                          
                         >
                         
                        <h4 class="text-2xl font-serif text-white mb-8 text-center text-shadow-sm">Express Yourself</h4>
                        <div class="space-y-6 mb-8">
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-1.5 ml-1">Write a little about yourself...</label>
                                <textarea name="about_yourself" x-model="formData.about_yourself" required rows="4" placeholder="I am a caring and passionate person who loves..." class="w-full px-5 py-3.5 rounded-xl theme-input"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-white/90 mb-3 ml-1">Hobbies & Interests</label>
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="hobby in ['Creative', 'Fun', 'Fitness', 'Music', 'Travel', 'Reading', 'Cooking', 'Photography', 'Sports', 'Art']">
                                        <label class="px-5 py-2.5 rounded-full cursor-pointer transition-all duration-300 shadow-sm" :class="formData.hobbies.includes(hobby) ? 'selected option-btn' : 'option-btn'">
                                            <input type="checkbox" name="hobbies_interests[]" :value="hobby" x-model="formData.hobbies" class="hidden">
                                            <span class="text-sm font-medium" x-text="hobby"></span>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" @click="nextStep" :disabled="!formData.about_yourself" class="w-full theme-btn py-4 rounded-full text-lg">Continue</button>
                        </div>
                    </div>

                    <!-- Step 13: OTP Verification -->
                    <div x-show="step === 13" style="display: none;"
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-12" 
                         x-transition:enter-end="opacity-100 translate-x-0" 
                          
                          
                         >
                         
                        <div class="flex justify-center mb-6">
                            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center text-rani-gold border border-rani-gold/50 shadow-[0_0_15px_rgba(212,175,55,0.3)]">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                        </div>
                        <h4 class="text-2xl font-serif text-white mb-2 text-center text-shadow-sm">Verify Your Number</h4>
                        <p class="text-sm text-white/80 text-center mb-8 font-light">A 4-digit secret code has been sent to <span class="font-bold text-rani-gold" x-text="formData.mobile"></span></p>
                        
                        <div class="flex justify-center gap-4 mb-10" x-data="{ otpInputs: ['', '', '', ''] }">
                            <template x-for="(digit, index) in otpInputs" :key="index">
                                <input type="text" maxlength="1" x-model="otpInputs[index]" @input="handleOtpInput($event, index); otp = otpInputs.join('')" class="w-16 h-16 text-center text-3xl font-bold bg-white/70 border border-rani-gold/50 rounded-2xl focus:border-rani-gold focus:ring-4 focus:ring-rani-gold/30 outline-none otp-input text-[#4a0404] shadow-sm transition-all">
                            </template>
                        </div>
                        
                        <div class="mt-4">
                            <button type="button" @click="verifyOtp" :disabled="otp.length !== 4 || isVerifyingOtp" class="w-full theme-btn py-4 rounded-full text-lg flex justify-center items-center">
                                <span x-show="!isVerifyingOtp">Verify OTP</span>
                                <svg x-show="isVerifyingOtp" class="animate-spin h-6 w-6 text-[#4a0404]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display:none;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 14: Selfie & Profile Picture -->
                    <div x-show="step === 14" style="display: none;"
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-12" 
                         x-transition:enter-end="opacity-100 translate-x-0" 
                          
                          
                         >
                         
                        <h4 class="text-2xl font-serif text-white mb-6 text-center text-shadow-sm">Profile Picture</h4>
                        
                        <div class="mb-6">
                            <div class="border-2 border-dashed border-rani-gold/50 bg-white/20 hover:bg-white/30 transition-colors rounded-2xl p-6 text-center cursor-pointer flex flex-col items-center justify-center backdrop-blur-sm" @click="$refs.fileInput.click()">
                                <template x-if="!imagePreview">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-rani-gold rounded-full flex items-center justify-center shadow-sm mb-3 text-[#4a0404]">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <p class="text-sm font-medium text-white">Upload Profile Picture</p>
                                    </div>
                                </template>
                                <template x-if="imagePreview">
                                    <div class="w-28 h-28 mx-auto rounded-full overflow-hidden border-4 border-rani-gold shadow-lg">
                                        <img :src="imagePreview" class="w-full h-full object-cover">
                                    </div>
                                </template>
                            </div>
                            <input type="file" name="profile_picture" x-ref="fileInput" @change="handleFileUpload" class="hidden" accept="image/*">
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <button type="button" @click="startCamera" class="flex-1 py-4 px-4 rounded-xl option-btn font-medium flex flex-col items-center group">
                                <svg class="w-7 h-7 mb-2 text-rani-gold group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                Take Live Selfie
                            </button>
                            <button type="button" @click="mockPhoneSelfie($event)" class="flex-1 py-4 px-4 rounded-xl option-btn font-medium flex flex-col items-center group">
                                <svg class="w-7 h-7 mb-2 text-rani-gold group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                Link to Phone
                            </button>
                        </div>

                        <div x-show="isCameraOpen" class="mt-6 border-4 border-rani-gold rounded-2xl overflow-hidden relative bg-black shadow-2xl" style="display: none;">
                            <video x-ref="videoElement" autoplay playsinline class="w-full h-auto"></video>
                            <button type="button" @click="takeSelfie" class="absolute bottom-6 left-1/2 transform -translate-x-1/2 bg-white text-[#4a0404] rounded-full p-4 shadow-[0_0_20px_rgba(212,175,55,0.8)] hover:scale-110 transition-transform border-4 border-rani-gold">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                            </button>
                        </div>
                        <canvas x-ref="canvasElement" class="hidden"></canvas>

                        <div x-show="isSelfieVerified" class="mt-6 p-4 bg-green-500/20 border border-green-400 text-green-100 rounded-xl text-center font-medium shadow-sm flex items-center justify-center gap-2 backdrop-blur-sm" style="display: none;">
                            <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Identity Verified!
                        </div>
                        
                        <div class="mt-8 pt-6 border-t border-white/20">
                            <button type="submit" class="w-full theme-btn text-[#4a0404] font-bold py-4.5 rounded-full text-xl transition-all flex justify-center items-center h-14">
                                <span x-show="!isSubmitting">Complete Registration</span>
                                <svg x-show="isSubmitting" class="animate-spin h-6 w-6 text-[#4a0404]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display:none;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
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
                dob_day: '', dob_month: '', dob_year: '', religion: '', community: '',
                email: '', mobile: '',
                country: '', state: '', city: '', sub_community: '', full_address: '',
                marital_status: '', height: '', diet: '',
                highest_qualification: '', college_name: '', college_address: '',
                income_type: '',
                profession: '', designation: '', company_name: '', company_address: '',
                about_yourself: '',
                aadhar_number: '',
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
            showError(msg, title = 'Missing Information') {
                Swal.fire({
                    icon: 'error',
                    title: title,
                    text: msg,
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                });
            },
            showSuccess(title, text) {
                Swal.fire({
                    icon: 'success',
                    title: title,
                    text: text,
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                });
            },
            nextStep() {
                // Validation before advancing
                if (this.step === 1 && !this.formData.profile_for) return this.showError("Please select who this profile is for.");
                if (this.step === 2 && !this.formData.gender) return this.showError("Please select gender.");
                
                if (this.step === 3) {
                    if (!this.formData.first_name || !this.formData.last_name) return this.showError("First name and Last name are required.");
                    if (!this.formData.aadhar_number || this.formData.aadhar_number.length !== 12) return this.showError("Please enter a valid 12-digit Aadhar Number.");
                    
                    fetch('/api/check-user-exists', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
                        body: JSON.stringify({ aadhar_number: this.formData.aadhar_number })
                    })
                    .then(res => {
                        if (!res.ok) return res.json().then(err => { throw err; });
                        return res.json();
                    })
                    .then(data => {
                        if (data.exists) {
                            this.showError(data.message, 'Account Exists');
                        } else {
                            this.step++;
                        }
                    })
                    .catch(err => {
                        if (err && err.errors) {
                            const firstError = Object.values(err.errors)[0][0];
                            this.showError(firstError, 'Invalid Input');
                        } else {
                            this.showError("Error verifying details.", 'Error');
                        }
                    });
                    return; // Prevent normal advancement
                }

                if (this.step === 4 && (!this.formData.dob_day || !this.formData.dob_month || !this.formData.dob_year)) return this.showError("Date of Birth is required.");
                if (this.step === 5 && (!this.formData.religion || !this.formData.community)) return this.showError("Religion and Community are required.");
                if (this.step === 6) {
                    if (!this.formData.email || !this.formData.mobile) return this.showError("Email and Mobile number are required.");
                    
                    fetch('/api/check-user-exists', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
                        body: JSON.stringify({ email: this.formData.email, mobile: this.formData.mobile })
                    })
                    .then(res => {
                        if (!res.ok) {
                            return res.json().then(err => { throw err; });
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (data.exists) {
                            this.showError(data.message, 'Account Exists');
                        } else {
                            this.step++;
                        }
                    })
                    .catch(err => {
                        if (err && err.errors) {
                            const firstError = Object.values(err.errors)[0][0];
                            this.showError(firstError, 'Invalid Input');
                        } else {
                            this.showError("Error verifying details.", 'Error');
                        }
                    });
                    return; // Prevent normal advancement
                }

                if (this.step === 7) {
                    if (!this.formData.country || !this.formData.state || !this.formData.city) return this.showError("Country, State, and City are required.");
                    if (!this.formData.full_address) return this.showError("Full Address is required.");
                }
                
                if (this.step === 8 && (!this.formData.marital_status || !this.formData.height || !this.formData.diet)) return this.showError("Physical & Diet details are required.");
                if (this.step === 9 && !this.formData.highest_qualification) return this.showError("Highest Qualification is required.");
                if (this.step === 10 && !this.formData.income_type) return this.showError("Income detail is required.");
                if (this.step === 11 && (!this.formData.profession || !this.formData.designation)) return this.showError("Career details are required.");
                if (this.step === 12 && !this.formData.about_yourself) return this.showError("Please write a little about yourself.");

                if (this.step === 12) {
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
                this.isOtpSending = true;
                fetch('/api/send-registration-otp', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
                    body: JSON.stringify({ mobile: this.formData.mobile })
                })
                .then(res => res.json())
                .then(data => {
                    this.isOtpSending = false;
                    this.showSuccess('OTP Sent', 'A verification code has been sent to ' + this.formData.mobile);
                })
                .catch(err => {
                    this.isOtpSending = false;
                    this.showError('Error sending OTP.');
                });
            },
            verifyOtp() {
                if(this.otp.length !== 4) return this.showError("Please enter the 4-digit OTP.");
                
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
                        this.showError('Invalid OTP. Please try again.');
                        const inputs = document.querySelectorAll('.otp-input');
                        inputs.forEach(i => i.value = '');
                        this.otp = '';
                    }
                })
                .catch(err => {
                    this.isVerifyingOtp = false;
                    this.showError('Error verifying OTP.');
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
                        this.showError("Camera access required for PC selfie.");
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
            mockPhoneSelfie(e) {
                const btn = e?.currentTarget;
                if(btn) btn.innerHTML = 'Sending...';
                
                fetch('/api/send-selfie-link', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
                    body: JSON.stringify({ mobile: this.formData.mobile })
                })
                .then(res => res.json())
                .then(data => {
                    if(btn) btn.innerHTML = 'Link Sent!';
                    this.showSuccess('Secure Link Sent!', 'Please open WhatsApp on your phone, click the link, and follow the instructions to take your selfie.');
                    
                    // Start Polling for selfie status
                    let attempts = 0;
                    const pollInterval = setInterval(() => {
                        attempts++;
                        if (attempts > 100) { // Timeout after ~5 mins
                            clearInterval(pollInterval);
                            return;
                        }
                        
                        fetch('/api/check-selfie-status?phone=' + this.formData.mobile)
                            .then(r => r.json())
                            .then(statusData => {
                                if (statusData.success && statusData.selfie_data) {
                                    clearInterval(pollInterval);
                                    this.selfieDataUrl = statusData.selfie_data;
                                    this.isSelfieVerified = true;
                                }
                            });
                    }, 3000); // Check every 3 seconds

                })
                .catch(err => {
                    if(btn) btn.innerHTML = 'Try Again';
                    this.showError("Error sending link. Please try again.");
                });
            },
            submitForm(e) {
                if(this.isSubmitting) return;
                this.isSubmitting = true;
                
                const form = document.getElementById('unifiedRegForm');
                
                // Construct FormData properly from Alpine state
                const fd = new FormData();
                for (const key in this.formData) {
                    if (key !== 'profile_image') {
                        fd.append(key, this.formData[key]);
                    }
                }
                // Construct dob field as expected by backend
                fd.append('dob', `${this.formData.dob_year}-${this.formData.dob_month}-${this.formData.dob_day}`);
                
                if (this.selfieDataUrl) {
                    const byteString = atob(this.selfieDataUrl.split(',')[1]);
                    const ab = new ArrayBuffer(byteString.length);
                    const ia = new Uint8Array(ab);
                    for (let i = 0; i < byteString.length; i++) {
                        ia[i] = byteString.charCodeAt(i);
                    }
                    const blob = new Blob([ab], { type: 'image/jpeg' });
                    fd.append('selfie_image', blob, 'selfie.jpg');
                }
                
                fetch(form.action, {
                    method: 'POST',
                    body: fd,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    this.isSubmitting = false;
                    if(data.success && data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        this.showError(data.message || 'An error occurred during registration.');
                    }
                })
                .catch(error => {
                    this.isSubmitting = false;
                    this.showError('An error occurred. Please try again.');
                });
            }
        }
    }
</script>
@endsection
