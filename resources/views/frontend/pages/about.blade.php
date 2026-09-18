@extends('frontend.layouts.app')

@section('title', 'About Us | Rani Matrimonial - Where Soulmates Meet')

@section('content')
<div class="relative min-h-[100svh] pt-28 md:pt-36 pb-20 overflow-x-hidden">
    <!-- Hero Background Image -->
    <div class="fixed inset-0 z-0 bg-cover bg-top bg-no-repeat pointer-events-none" style="background-image: url('{{ asset('img/hero.png') }}');"></div>
    
    <!-- Maroon/Gold Gradient Overlay -->
    <div class="fixed inset-0 z-0 bg-gradient-to-t from-rani-dark/95 via-rani-primary-dark/85 to-rani-primary-dark/55 pointer-events-none"></div>

    <!-- Floating Hearts -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none heart-container opacity-40">
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

    <!-- Main Container -->
    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Hero Header -->
        <div class="text-center mb-12 md:mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-rani-gold/40 text-rani-gold font-medium text-xs sm:text-sm uppercase tracking-widest mb-4 shadow-lg">
                <span class="w-2 h-2 rounded-full bg-rani-gold animate-ping"></span>
                Our Heritage & Vision
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-serif font-bold text-white mb-4 tracking-tight drop-shadow-md">
                About <span class="text-transparent bg-clip-text bg-gradient-to-r from-rani-gold via-amber-200 to-rani-gold">Rani Matrimonial</span>
            </h1>
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="h-[1px] w-12 sm:w-20 bg-rani-gold"></div>
                <div class="w-2.5 h-2.5 rotate-45 bg-rani-gold shadow-[0_0_10px_#D4AF37]"></div>
                <div class="h-[1px] w-12 sm:w-20 bg-rani-gold"></div>
            </div>
            <p class="text-base sm:text-xl text-rani-gold-light/90 font-light max-w-3xl mx-auto leading-relaxed drop-shadow">
                Where royal Indian traditions intertwine with modern technology to help you find your lifelong companion with honor, trust, and authenticity.
            </p>
        </div>

        <!-- Key Highlights / Numbers Bar -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-14">
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl sm:rounded-3xl p-4 sm:p-6 text-center hover:bg-white/15 transition-all duration-300 hover:border-rani-gold/60 shadow-xl">
                <div class="text-2xl sm:text-4xl font-serif font-bold text-rani-gold mb-1">50,000+</div>
                <p class="text-xs sm:text-sm text-white/90 font-medium">Happy Couples & Families</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl sm:rounded-3xl p-4 sm:p-6 text-center hover:bg-white/15 transition-all duration-300 hover:border-rani-gold/60 shadow-xl">
                <div class="text-2xl sm:text-4xl font-serif font-bold text-rani-gold mb-1">100%</div>
                <p class="text-xs sm:text-sm text-white/90 font-medium">Aadhar & Photo Verified</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl sm:rounded-3xl p-4 sm:p-6 text-center hover:bg-white/15 transition-all duration-300 hover:border-rani-gold/60 shadow-xl">
                <div class="text-2xl sm:text-4xl font-serif font-bold text-rani-gold mb-1">28+</div>
                <p class="text-xs sm:text-sm text-white/90 font-medium">States & Communities</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl sm:rounded-3xl p-4 sm:p-6 text-center hover:bg-white/15 transition-all duration-300 hover:border-rani-gold/60 shadow-xl">
                <div class="text-2xl sm:text-4xl font-serif font-bold text-rani-gold mb-1">24 / 7</div>
                <p class="text-xs sm:text-sm text-white/90 font-medium">Dedicated Support</p>
            </div>
        </div>

        <!-- Section 1: Who We Are & Our Story -->
        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border border-white/60 p-6 sm:p-10 lg:p-12 mb-12 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-90"></div>
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                <div class="lg:col-span-7 space-y-4 text-gray-700 leading-relaxed font-sans">
                    <div class="inline-flex items-center gap-2 text-rani-primary font-bold text-xs sm:text-sm tracking-widest uppercase">
                        <span class="w-6 h-0.5 bg-rani-gold"></span>
                        Our Origin & Purpose
                    </div>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-bold text-rani-primary-dark">
                        Empowering Indian Families with Sacred & Trusted Matchmaking
                    </h2>
                    <p class="text-base text-gray-700">
                        Founded under the visionary leadership of <strong class="text-rani-primary-dark font-semibold">Sumatra Sales Private Limited</strong>, <strong class="text-rani-primary-dark font-semibold">Rani Matrimonial</strong> was conceived with a clear and compassionate mission: to bridge the gap between rich cultural customs and contemporary matrimonial aspirations.
                    </p>
                    <p class="text-base text-gray-700">
                        In an era dominated by superficial casual dating platforms and impersonal algorithms, marriage remains one of the most sacred turning points in Indian society. We honor this sanctity by providing a secure, verified, and family-friendly environment where genuine brides, grooms, and their families can connect in complete confidence.
                    </p>
                    <div class="pt-2 flex flex-wrap gap-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rani-primary/10 text-rani-primary-dark text-xs sm:text-sm font-semibold">
                            <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Strict Verification Standards
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rani-primary/10 text-rani-primary-dark text-xs sm:text-sm font-semibold">
                            <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Privacy Control on Contact Details
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rani-primary/10 text-rani-primary-dark text-xs sm:text-sm font-semibold">
                            <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Culturally Sensitive
                        </span>
                    </div>
                </div>

                <div class="lg:col-span-5 flex justify-center">
                    <div class="relative w-full max-w-sm rounded-3xl p-1 bg-gradient-to-tr from-rani-gold via-amber-200 to-rani-gold-light shadow-2xl">
                        <div class="bg-rani-primary-dark rounded-[22px] p-6 sm:p-8 text-white relative overflow-hidden">
                            <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-rani-gold/10 rounded-full blur-2xl"></div>
                            <div class="w-16 h-16 rounded-2xl bg-white/10 border border-rani-gold/40 flex items-center justify-center text-rani-gold mb-6 shadow-inner">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-serif font-bold text-rani-gold mb-3">Our Core Promise</h3>
                            <p class="text-sm sm:text-base text-rani-light/90 font-light leading-relaxed mb-4">
                                "Every profile on Rani Matrimonial represents someone's cherished son, daughter, brother, or sister. We treat every match with the same reverence and responsibility we would for our own family."
                            </p>
                            <div class="border-t border-white/20 pt-4 flex items-center justify-between">
                                <span class="text-xs text-rani-gold-light uppercase tracking-wider font-semibold">Sumatra Sales Pvt. Ltd.</span>
                                <span class="text-xs text-white/70">ISO Quality Standards</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Mission & Vision -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 mb-12">
            <!-- Mission Card -->
            <div class="bg-gradient-to-br from-white/95 to-[#FFFBF2] backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-white/60 shadow-xl flex flex-col justify-between hover:shadow-2xl transition-all duration-300">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-rani-primary/10 border border-rani-gold/30 flex items-center justify-center text-rani-primary mb-5 shadow-sm">
                        <svg class="w-7 h-7 text-rani-primary-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-serif font-bold text-rani-primary-dark mb-3">Our Mission</h3>
                    <p class="text-gray-700 leading-relaxed text-sm sm:text-base">
                        To build India's most dependable and elegant matchmaking network where privacy is uncompromised, verification is genuine, and finding the right life partner is an uplifting, joyful, and dignified experience.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 flex items-center gap-2 text-xs font-semibold text-rani-primary-dark">
                    <span class="w-2 h-2 rounded-full bg-rani-gold"></span>
                    Authenticity • Reliability • Compassion
                </div>
            </div>

            <!-- Vision Card -->
            <div class="bg-gradient-to-br from-white/95 to-[#FFFBF2] backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-white/60 shadow-xl flex flex-col justify-between hover:shadow-2xl transition-all duration-300">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-rani-primary/10 border border-rani-gold/30 flex items-center justify-center text-rani-primary mb-5 shadow-sm">
                        <svg class="w-7 h-7 text-rani-primary-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-serif font-bold text-rani-primary-dark mb-3">Our Vision</h3>
                    <p class="text-gray-700 leading-relaxed text-sm sm:text-base">
                        To redefine matrimonial matchmaking across India by combining cutting-edge digital matchmaking tools, regional branch support, and strict safety guidelines to ensure that every union is built on truth and shared dreams.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 flex items-center gap-2 text-xs font-semibold text-rani-primary-dark">
                    <span class="w-2 h-2 rounded-full bg-rani-gold"></span>
                    Respect • Innovation • Lifelong Bonds
                </div>
            </div>
        </div>

        <!-- Section 3: Why Choose Rani Matrimonial (6 Pillars) -->
        <div class="mb-14">
            <div class="text-center mb-10">
                <h2 class="text-2xl sm:text-4xl font-serif font-bold text-white mb-3">
                    Why Millions Trust Rani Matrimonial
                </h2>
                <p class="text-sm sm:text-base text-rani-gold-light/90 max-w-xl mx-auto font-light">
                    Every feature on our platform is carefully curated to give you peace of mind and meaningful results.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Pillar 1 -->
                <div class="bg-white/90 backdrop-blur-md rounded-2xl p-6 border border-white/60 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-rani-primary text-rani-gold flex items-center justify-center mb-4 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h4 class="text-lg font-serif font-bold text-rani-primary-dark mb-2">Blue Tick & Aadhar Verification</h4>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        We screen candidates with Aadhar validation, live selfie checks, and mobile OTP verifications to eliminate fake profiles.
                    </p>
                </div>

                <!-- Pillar 2 -->
                <div class="bg-white/90 backdrop-blur-md rounded-2xl p-6 border border-white/60 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-rani-primary text-rani-gold flex items-center justify-center mb-4 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h4 class="text-lg font-serif font-bold text-rani-primary-dark mb-2">100% Privacy & Contact Protection</h4>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Your phone number and WhatsApp credentials are never shared publicly without your explicit mutual consent and verification.
                    </p>
                </div>

                <!-- Pillar 3 -->
                <div class="bg-white/90 backdrop-blur-md rounded-2xl p-6 border border-white/60 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-rani-primary text-rani-gold flex items-center justify-center mb-4 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h4 class="text-lg font-serif font-bold text-rani-primary-dark mb-2">Rich Community Filters</h4>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Filter by Religion, Sub-community, Caste, Education, Career, Income, Dietary preferences, and Lifestyle choices easily.
                    </p>
                </div>

                <!-- Pillar 4 -->
                <div class="bg-white/90 backdrop-blur-md rounded-2xl p-6 border border-white/60 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-rani-primary text-rani-gold flex items-center justify-center mb-4 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h4 class="text-lg font-serif font-bold text-rani-primary-dark mb-2">Intelligent Matching</h4>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Our intelligent recommendation algorithm finds compatible profiles matching your personality, hobbies, and mutual expectations.
                    </p>
                </div>

                <!-- Pillar 5 -->
                <div class="bg-white/90 backdrop-blur-md rounded-2xl p-6 border border-white/60 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-rani-primary text-rani-gold flex items-center justify-center mb-4 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h4 class="text-lg font-serif font-bold text-rani-primary-dark mb-2">Branch & Matchmaker Support</h4>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Assisted by regional branch managers and referral coordinators to support candidates and parents through every step.
                    </p>
                </div>

                <!-- Pillar 6 -->
                <div class="bg-white/90 backdrop-blur-md rounded-2xl p-6 border border-white/60 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-rani-primary text-rani-gold flex items-center justify-center mb-4 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-lg font-serif font-bold text-rani-primary-dark mb-2">Transparent Wallet & Direct Access</h4>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Pay only for the contacts you wish to unlock with simple wallet points. No hidden charges or automatic recurring debits.
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 4: Our Step-by-Step Matchmaking Process -->
        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border border-white/60 p-6 sm:p-10 lg:p-12 mb-14 relative overflow-hidden">
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 text-rani-primary font-bold text-xs sm:text-sm tracking-widest uppercase mb-2">
                    <span class="w-6 h-0.5 bg-rani-gold"></span>
                    Simple & Joyful
                    <span class="w-6 h-0.5 bg-rani-gold"></span>
                </div>
                <h3 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-bold text-rani-primary-dark">
                    How Rani Matrimonial Works
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                <div class="relative flex flex-col items-center">
                    <div class="w-14 h-14 rounded-full bg-rani-primary text-rani-gold border-2 border-rani-gold flex items-center justify-center font-bold text-xl mb-4 shadow-md">
                        1
                    </div>
                    <h4 class="text-lg font-serif font-bold text-rani-primary-dark mb-1">Create Profile</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Register for free in minutes. Fill in personal details, education, career, and lifestyle preferences.
                    </p>
                </div>

                <div class="relative flex flex-col items-center">
                    <div class="w-14 h-14 rounded-full bg-rani-primary text-rani-gold border-2 border-rani-gold flex items-center justify-center font-bold text-xl mb-4 shadow-md">
                        2
                    </div>
                    <h4 class="text-lg font-serif font-bold text-rani-primary-dark mb-1">Verify Identity</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Complete your Aadhar verification and upload your selfie to earn a prestigious Blue Tick badge.
                    </p>
                </div>

                <div class="relative flex flex-col items-center">
                    <div class="w-14 h-14 rounded-full bg-rani-primary text-rani-gold border-2 border-rani-gold flex items-center justify-center font-bold text-xl mb-4 shadow-md">
                        3
                    </div>
                    <h4 class="text-lg font-serif font-bold text-rani-primary-dark mb-1">Connect & Shortlist</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Explore matching profiles, send free Interests, and receive connection requests directly in your inbox.
                    </p>
                </div>

                <div class="relative flex flex-col items-center">
                    <div class="w-14 h-14 rounded-full bg-rani-primary text-rani-gold border-2 border-rani-gold flex items-center justify-center font-bold text-xl mb-4 shadow-md">
                        4
                    </div>
                    <h4 class="text-lg font-serif font-bold text-rani-primary-dark mb-1">Family Union</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Initiate verified WhatsApp chats, involve parents and elders, and begin a lifetime of companionship!
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 5: CTA Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-rani-primary-dark via-rani-primary to-rani-primary-dark p-8 sm:p-12 text-center text-white shadow-2xl border-2 border-rani-gold/60">
            <div class="absolute -top-24 -left-24 w-48 h-48 bg-rani-gold/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-rani-gold/20 rounded-full blur-3xl"></div>

            <h3 class="text-2xl sm:text-4xl font-serif font-bold text-white mb-3">
                Your Soulmate Is Waiting For You
            </h3>
            <p class="text-sm sm:text-base text-rani-gold-light/90 max-w-2xl mx-auto mb-8 font-light leading-relaxed">
                Take the first step toward a beautiful future. Register in less than 2 minutes and explore handpicked, verified profiles tailored just for you.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('register.page') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 rounded-full font-bold text-base bg-gradient-to-r from-rani-gold via-amber-200 to-rani-gold text-rani-primary-dark shadow-xl hover:shadow-rani-gold/40 hover:scale-105 transition-all duration-300">
                    Register Free Today
                </a>
                <a href="{{ route('search') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 rounded-full font-semibold text-base border-2 border-rani-gold/70 text-rani-gold-light hover:bg-white/10 hover:text-white transition-all duration-300">
                    Search Profiles
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
