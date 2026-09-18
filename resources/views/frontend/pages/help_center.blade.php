@extends('frontend.layouts.app')

@section('title', 'Help Center & Contact Us | Rani Matrimonial')

@section('content')
<div class="relative min-h-[100svh] pt-24 sm:pt-28 md:pt-36 pb-16 md:pb-20 overflow-x-hidden" x-data="{ isSubmitting: false }">
    
    <!-- Background Image -->
    <div class="fixed inset-0 z-0 bg-cover bg-top bg-no-repeat pointer-events-none" style="background-image: url('{{ asset('img/hero.png') }}');"></div>
    
    <!-- Maroon/Gold Gradient Overlay -->
    <div class="fixed inset-0 z-0 bg-gradient-to-t from-rani-dark/95 via-rani-primary-dark/85 to-rani-primary-dark/60 pointer-events-none"></div>

    <!-- Floating Sweet Gestures (Hearts) -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none heart-container opacity-40">
        <div class="heart-floating delay-1"></div>
        <div class="heart-floating heart-maroon delay-2"></div>
        <div class="heart-floating delay-3"></div>
        <div class="heart-floating heart-maroon delay-4"></div>
        <div class="heart-floating delay-5"></div>
        <div class="heart-floating heart-maroon delay-1" style="left: 20%; animation-delay: 7s;"></div>
        <div class="heart-floating delay-2" style="left: 40%; animation-delay: 9s;"></div>
        <div class="heart-floating heart-maroon delay-3" style="left: 60%; animation-delay: 2s;"></div>
        <div class="heart-floating delay-4" style="left: 80%; animation-delay: 14s;"></div>
    </div>

    <!-- Main Container Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-3.5 sm:px-6 lg:px-8">
        
        <!-- Hero Header Title -->
        <div class="text-center mb-8 sm:mb-10 md:mb-14 px-2">
            <div class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1 sm:py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-rani-gold/40 text-rani-gold font-semibold text-[10px] sm:text-xs uppercase tracking-wider sm:tracking-widest mb-3 sm:mb-4 shadow-lg">
                <i class="ri-customer-service-2-line text-xs sm:text-sm text-rani-gold"></i>
                <span>We're Always Here To Help You</span>
            </div>
            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-2.5 sm:mb-3 tracking-tight drop-shadow-md leading-tight">
                Help Center & Contact Us
            </h1>
            <div class="flex items-center justify-center gap-3 sm:gap-4 mb-3 sm:mb-4">
                <div class="h-[1px] w-8 sm:w-12 bg-rani-gold"></div>
                <div class="w-1.5 sm:w-2 h-1.5 sm:h-2 rounded-full bg-rani-gold"></div>
                <div class="h-[1px] w-8 sm:w-12 bg-rani-gold"></div>
            </div>
            <p class="text-xs sm:text-sm md:text-base lg:text-lg text-rani-gold-light/90 font-light max-w-2xl mx-auto drop-shadow leading-relaxed">
                Have questions about matchmaking, profile verification, or subscriptions? Get in touch with our relationship team.
            </p>
        </div>

        <!-- Themed Luxury Success & Error Alerts -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="max-w-4xl mx-auto mb-6 sm:mb-8 bg-gradient-to-r from-rani-dark via-rani-primary-dark to-rani-dark border-2 border-rani-gold/80 text-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl shadow-2xl flex items-start justify-between gap-3.5 sm:gap-4 relative overflow-hidden backdrop-blur-md">
                <div class="absolute -right-8 -bottom-8 w-24 h-24 bg-rani-gold/15 rounded-full blur-xl pointer-events-none"></div>
                
                <div class="flex items-start gap-3 sm:gap-4 min-w-0">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-rani-gold/20 text-rani-gold flex items-center justify-center text-xl sm:text-2xl font-bold border border-rani-gold/40 shadow-inner shrink-0 mt-0.5">
                        <i class="ri-checkbox-circle-fill"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h4 class="font-serif font-bold text-sm sm:text-base md:text-lg text-rani-gold tracking-wide">
                            Message Delivered Successfully!
                        </h4>
                        <p class="text-xs sm:text-sm text-amber-100/90 mt-0.5 leading-relaxed font-light">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
                
                <button type="button" @click="show = false" class="text-rani-gold-light/70 hover:text-rani-gold p-1 rounded-lg transition shrink-0" title="Dismiss Alert">
                    <i class="ri-close-line text-xl sm:text-2xl"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="max-w-4xl mx-auto mb-6 sm:mb-8 bg-gradient-to-r from-rose-950 via-rani-dark to-rose-950 border-2 border-rose-500/70 text-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl shadow-2xl flex items-start justify-between gap-3.5 sm:gap-4 relative overflow-hidden backdrop-blur-md">
                <div class="flex items-start gap-3 sm:gap-4 min-w-0">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-rose-500/20 text-rose-400 flex items-center justify-center text-xl sm:text-2xl font-bold border border-rose-500/40 shadow-inner shrink-0 mt-0.5">
                        <i class="ri-error-warning-fill"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h4 class="font-serif font-bold text-sm sm:text-base md:text-lg text-rose-300 tracking-wide">
                            Please check the required fields:
                        </h4>
                        <ul class="list-disc list-inside text-xs sm:text-sm text-rose-200/90 mt-1 space-y-0.5">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" @click="show = false" class="text-rose-300/70 hover:text-rose-300 p-1 rounded-lg transition shrink-0" title="Dismiss Alert">
                    <i class="ri-close-line text-xl sm:text-2xl"></i>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-start max-w-6xl mx-auto">
            
            <!-- Contact & Help Form Card -->
            <div class="lg:col-span-7 bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl p-5 sm:p-7 md:p-9 shadow-2xl border border-rani-gold/30">
                <div class="flex items-center gap-3 sm:gap-3.5 pb-4 sm:pb-5 border-b border-gray-100 mb-5 sm:mb-6">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-rani-primary text-rani-gold flex items-center justify-center font-bold text-lg sm:text-xl shadow-md shrink-0">
                        <i class="ri-mail-send-line"></i>
                    </div>
                    <div>
                        <h2 class="text-lg sm:text-xl md:text-2xl font-serif font-bold text-rani-dark">Send us a Message</h2>
                        <p class="text-[11px] sm:text-xs md:text-sm text-gray-500 leading-tight mt-0.5">Fill in the details below and our team will respond directly via email.</p>
                    </div>
                </div>

                <form action="{{ route('help.submit') }}" method="POST" @submit="isSubmitting = true" class="space-y-4 sm:space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-[11px] sm:text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-rani-gold">
                                <i class="ri-user-3-line text-base sm:text-lg"></i>
                            </span>
                            <input type="text" id="name" name="name" required
                                value="{{ old('name', ($candidate ? trim($candidate->first_name . ' ' . $candidate->last_name) : '')) }}"
                                placeholder="Enter your full name"
                                class="w-full pl-10 pr-3.5 py-2.5 sm:py-3 rounded-xl border border-gray-300 focus:border-rani-primary focus:ring-2 focus:ring-rani-primary/20 transition duration-150 text-xs sm:text-sm text-gray-900 placeholder-gray-400 @error('name') border-red-400 @enderror">
                        </div>
                        @error('name')
                            <p class="text-[11px] sm:text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-[11px] sm:text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-rani-gold">
                                <i class="ri-mail-line text-base sm:text-lg"></i>
                            </span>
                            <input type="email" id="email" name="email" required
                                value="{{ old('email', ($candidate ? $candidate->email : '')) }}"
                                placeholder="name@example.com"
                                class="w-full pl-10 pr-3.5 py-2.5 sm:py-3 rounded-xl border border-gray-300 focus:border-rani-primary focus:ring-2 focus:ring-rani-primary/20 transition duration-150 text-xs sm:text-sm text-gray-900 placeholder-gray-400 @error('email') border-red-400 @enderror">
                        </div>
                        @error('email')
                            <p class="text-[11px] sm:text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mobile with Country Code -->
                    <div>
                        <label for="mobile" class="block text-[11px] sm:text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Mobile Number <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-2">
                            <select name="country_code" class="w-24 sm:w-32 py-2.5 sm:py-3 px-2 rounded-xl border border-gray-300 bg-gray-50 text-xs sm:text-sm font-bold text-gray-700 focus:border-rani-primary focus:ring-2 focus:ring-rani-primary/20 transition shrink-0">
                                <option value="+91" {{ old('country_code', '+91') == '+91' ? 'selected' : '' }}>🇮🇳 +91</option>
                                <option value="+1" {{ old('country_code', '+1') == '+1' ? 'selected' : '' }}>🇺🇸 +1</option>
                                <option value="+44" {{ old('country_code', '+44') == '+44' ? 'selected' : '' }}>🇬🇧 +44</option>
                                <option value="+971" {{ old('country_code', '+971') == '+971' ? 'selected' : '' }}>🇦🇪 +971</option>
                                <option value="+65" {{ old('country_code', '+65') == '+65' ? 'selected' : '' }}>🇸🇬 +65</option>
                                <option value="+61" {{ old('country_code', '+61' ? 'selected' : '') == '+61' ? 'selected' : '' }}>🇦🇺 +61</option>
                                <option value="+880" {{ old('country_code', '+880') == '+880' ? 'selected' : '' }}>🇧🇩 +880</option>
                                <option value="+966" {{ old('country_code', '+966') == '+966' ? 'selected' : '' }}>🇸🇦 +966</option>
                                <option value="+974" {{ old('country_code', '+974') == '+974' ? 'selected' : '' }}>🇶🇦 +974</option>
                                <option value="+1-CA" {{ old('country_code', '+1-CA') == '+1-CA' ? 'selected' : '' }}>🇨🇦 +1</option>
                            </select>
                            <div class="relative flex-1 min-w-0">
                                <input type="tel" id="mobile" name="mobile" required
                                    value="{{ old('mobile', ($candidate ? $candidate->mobile : '')) }}"
                                    placeholder="10-digit mobile number"
                                    class="w-full px-3.5 py-2.5 sm:py-3 rounded-xl border border-gray-300 focus:border-rani-primary focus:ring-2 focus:ring-rani-primary/20 transition duration-150 text-xs sm:text-sm text-gray-900 placeholder-gray-400 @error('mobile') border-red-400 @enderror">
                            </div>
                        </div>
                        @error('mobile')
                            <p class="text-[11px] sm:text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-[11px] sm:text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Subject <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-rani-gold">
                                <i class="ri-chat-voice-line text-base sm:text-lg"></i>
                            </span>
                            <input type="text" id="subject" name="subject" required
                                value="{{ old('subject') }}"
                                placeholder="What can we help you with?"
                                class="w-full pl-10 pr-3.5 py-2.5 sm:py-3 rounded-xl border border-gray-300 focus:border-rani-primary focus:ring-2 focus:ring-rani-primary/20 transition duration-150 text-xs sm:text-sm text-gray-900 placeholder-gray-400 @error('subject') border-red-400 @enderror">
                        </div>
                        @error('subject')
                            <p class="text-[11px] sm:text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-[11px] sm:text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Your Message <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" name="message" rows="4" required
                            placeholder="Please explain your question or issue in detail..."
                            class="w-full px-3.5 py-2.5 sm:py-3 rounded-xl border border-gray-300 focus:border-rani-primary focus:ring-2 focus:ring-rani-primary/20 transition duration-150 text-xs sm:text-sm text-gray-900 placeholder-gray-400 @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-[11px] sm:text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold py-3 sm:py-3.5 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 active:scale-[0.99] text-xs sm:text-sm md:text-base border border-rani-gold/40">
                        <i class="ri-send-plane-fill text-rani-gold"></i>
                        <span>Submit Inquiry Now</span>
                    </button>
                </form>
            </div>

            <!-- Right Column: Support Cards & Helpline -->
            <div class="lg:col-span-5 space-y-5 sm:space-y-6">
                
                <!-- Support Notice Card for Logged In Candidates -->
                @auth('web')
                <div class="bg-gradient-to-br from-rani-dark via-rani-primary-dark to-rani-primary text-white rounded-2xl sm:rounded-3xl p-5 sm:p-7 shadow-2xl border border-rani-gold/40 relative overflow-hidden">
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-rani-gold/15 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="flex items-center gap-3 mb-2.5 sm:mb-3">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-rani-gold/20 text-rani-gold flex items-center justify-center text-lg sm:text-xl font-bold border border-rani-gold/30 shrink-0">
                            <i class="ri-customer-service-fill"></i>
                        </div>
                        <div>
                            <h3 class="font-serif font-bold text-base sm:text-lg text-white leading-tight">Candidate Support Desk</h3>
                            <span class="text-[10px] sm:text-xs text-rani-gold font-mono uppercase tracking-wider">Logged in Member</span>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm text-rani-gold-light/90 leading-relaxed mb-4 font-light">
                        As a registered candidate, you can create priority support tickets with screenshots and track admin replies in your support desk.
                    </p>
                    <a href="{{ route('support.index') }}" class="inline-flex items-center gap-1.5 sm:gap-2 bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-yellow-500 hover:to-amber-400 text-rani-dark font-bold px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm shadow-md transition transform hover:-translate-y-0.5">
                        <span>Open Support & Tickets</span>
                        <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
                @endauth

                <!-- Official Contact Details Card -->
                <div class="bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl p-5 sm:p-7 shadow-xl border border-rani-gold/30 space-y-4 sm:space-y-5">
                    <h3 class="text-sm sm:text-base font-serif font-bold text-rani-dark pb-2.5 sm:pb-3 border-b border-gray-100 flex items-center gap-2">
                        <i class="ri-contacts-book-2-line text-rani-primary"></i>
                        Direct Contact Information
                    </h3>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-rani-primary/10 text-rani-primary flex items-center justify-center shrink-0 border border-rani-primary/20">
                            <i class="ri-mail-line text-base sm:text-lg"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-gray-400 block">Support Email</span>
                            <a href="mailto:info.ranimatrimonial@gmail.com" class="font-bold text-gray-800 hover:text-rani-primary text-xs sm:text-sm md:text-base transition break-all">
                                info.ranimatrimonial@gmail.com
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-rani-primary/10 text-rani-primary flex items-center justify-center shrink-0 border border-rani-primary/20">
                            <i class="ri-phone-line text-base sm:text-lg"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-gray-400 block">Helpline</span>
                            <a href="tel:+916292237202" class="font-bold text-gray-800 hover:text-rani-primary text-xs sm:text-sm md:text-base transition">
                                +91 6292237202
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-rani-primary/10 text-rani-primary flex items-center justify-center shrink-0 border border-rani-primary/20">
                            <i class="ri-time-line text-base sm:text-lg"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-gray-400 block">Working Hours</span>
                            <div class="text-xs sm:text-sm font-semibold text-gray-700">
                                Monday - Sunday: 24/7
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Frequently Asked Questions Card -->
                <div class="bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl p-5 sm:p-7 shadow-xl border border-rani-gold/30">
                    <h3 class="text-sm sm:text-base font-serif font-bold text-rani-dark pb-2.5 sm:pb-3 border-b border-gray-100 flex items-center gap-2 mb-3 sm:mb-4">
                        <i class="ri-questionnaire-line text-rani-primary"></i>
                        Common Questions
                    </h3>

                    <div class="space-y-2.5 sm:space-y-3" x-data="{ active: 1 }">
                        <div class="border border-gray-200 rounded-xl sm:rounded-2xl p-3.5 sm:p-4 bg-white/70">
                            <button @click="active = (active === 1 ? null : 1)" class="w-full flex items-center justify-between text-left font-bold text-gray-800 text-xs sm:text-sm focus:outline-none gap-2">
                                <span>How do I get my profile verified?</span>
                                <i class="ri-arrow-down-s-line text-base sm:text-lg transition duration-200 shrink-0" :class="{ 'rotate-180 text-rani-primary': active === 1 }"></i>
                            </button>
                            <p x-show="active === 1" x-collapse class="text-[11px] sm:text-xs md:text-sm text-gray-600 mt-2 leading-relaxed">
                                Upload a clear selfie photograph and your government-approved identity card (Aadhaar or Passport) from your candidate profile to receive our trusted Blue Tick badge.
                            </p>
                        </div>

                        <div class="border border-gray-200 rounded-xl sm:rounded-2xl p-3.5 sm:p-4 bg-white/70">
                            <button @click="active = (active === 2 ? null : 2)" class="w-full flex items-center justify-between text-left font-bold text-gray-800 text-xs sm:text-sm focus:outline-none gap-2">
                                <span>How long does it take for support to respond?</span>
                                <i class="ri-arrow-down-s-line text-base sm:text-lg transition duration-200 shrink-0" :class="{ 'rotate-180 text-rani-primary': active === 2 }"></i>
                            </button>
                            <p x-show="active === 2" x-collapse class="text-[11px] sm:text-xs md:text-sm text-gray-600 mt-2 leading-relaxed">
                                Most inquiries and tickets are responded to within 2 to 4 business hours. Urgent priority tickets receive expedited assistance.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Submission Loader Overlay Popup Modal -->
    <div x-show="isSubmitting" x-cloak
        class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100">
        
        <div class="bg-gradient-to-b from-rani-dark via-rani-primary-dark to-rani-dark p-7 sm:p-9 rounded-3xl border-2 border-rani-gold/60 shadow-2xl text-center max-w-sm w-full mx-auto relative overflow-hidden"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="scale-90 translate-y-4"
            x-transition:enter-end="scale-100 translate-y-0">
            
            <!-- Decorative glow rings -->
            <div class="absolute -top-12 -left-12 w-28 h-28 bg-rani-gold/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -right-12 w-28 h-28 bg-rani-primary/40 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Animated Royal Spinner & Icon -->
            <div class="relative w-20 h-20 mx-auto mb-5 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border-4 border-rani-gold/20"></div>
                <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-rani-gold border-r-rani-gold animate-spin"></div>
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-rani-primary to-rani-primary-dark flex items-center justify-center text-rani-gold text-2xl shadow-inner border border-rani-gold/40">
                    <i class="ri-mail-send-fill animate-pulse"></i>
                </div>
            </div>

            <h3 class="text-lg sm:text-xl font-serif font-bold text-white mb-1.5 tracking-wide">
                Delivering Your Message...
            </h3>
            <div class="flex items-center justify-center gap-2 mb-3">
                <div class="h-[1px] w-8 bg-rani-gold/60"></div>
                <div class="w-1.5 h-1.5 rounded-full bg-rani-gold"></div>
                <div class="h-[1px] w-8 bg-rani-gold/60"></div>
            </div>
            <p class="text-xs sm:text-[13px] text-rani-gold-light/90 leading-relaxed font-light">
                Please wait a moment while we process your inquiry and dispatch your confirmation email.
            </p>
        </div>
    </div>
</div>
@endsection
