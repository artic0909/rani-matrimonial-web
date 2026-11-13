@extends('frontend.layouts.app')

@section('title', 'Child Safety Standards & CSAE Policy | Rani Matrimonial')

@section('content')
<div class="relative min-h-[100svh] pt-28 md:pt-36 pb-20 overflow-x-hidden">
    <!-- Background Image -->
    <div class="fixed inset-0 z-0 bg-cover bg-top bg-no-repeat pointer-events-none" style="background-image: url('{{ asset('img/hero.png') }}');"></div>
    
    <!-- Maroon/Gold Gradient Overlay -->
    <div class="fixed inset-0 z-0 bg-gradient-to-t from-rani-dark/95 via-rani-primary-dark/80 to-rani-primary-dark/50 pointer-events-none"></div>

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

    <!-- Container Content -->
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Hero Banner Title -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-900/40 backdrop-blur-md border border-rani-gold/50 text-rani-gold font-medium text-xs sm:text-sm uppercase tracking-widest mb-4 shadow-lg">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Official Safety Policy & Google Play Compliance
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-4 tracking-tight drop-shadow-md">
                Child Safety Standards & CSAE Zero-Tolerance Policy
            </h1>
            <p class="text-base sm:text-lg text-rani-gold-light/90 font-light max-w-2xl mx-auto drop-shadow">
                Published standards of <strong class="text-white font-semibold">Rani Matrimonial</strong>, owned & operated by <strong class="text-white font-semibold">Sumatra Sales Pvt. Ltd.</strong> (Sumatra Sales Private Limited), prohibiting Child Sexual Abuse and Exploitation (CSAE).
            </p>
            <div class="mt-4 text-xs text-rani-gold-light/60">
                Effective & Last Updated Date: {{ date('F d, Y') }}
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border border-white/60 p-6 sm:p-10 lg:p-12 relative overflow-hidden hover:shadow-rani-gold/10 transition-all duration-500">
            <!-- Top Accent Bar -->
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-600 via-rani-gold to-rani-primary opacity-90"></div>

            <!-- Document Body -->
            <div class="prose prose-slate max-w-none space-y-10 text-gray-700 leading-relaxed font-sans">

                <!-- 1. Policy Statement & Developer Details -->
                <section class="border-b border-gray-100 pb-8">
                    <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-rani-light/60 text-rani-primary-dark text-sm font-bold shadow-sm border border-rani-gold/20">1</span>
                        Developer & Application Scope
                    </h2>
                    <p class="mb-4">
                        This Child Safety Standards Policy applies to the mobile application <strong>Rani Matrimonial</strong> (Package: <code>com.rani.matrimonial</code>) and its official website (<a href="{{ url('/') }}" class="text-rani-primary font-semibold hover:underline">ranimatrimonial.com</a>), developed, owned, and published by:
                    </p>
                    <div class="bg-rani-light/40 border border-rani-gold/30 rounded-2xl p-5 mb-4 text-sm text-gray-800 space-y-1.5">
                        <p><strong>Application Title:</strong> Rani Matrimonial</p>
                        <p><strong>Developer Entity Name:</strong> Sumatra Sales Pvt. Ltd. (registered as Sumatra Sales Private Limited)</p>
                        <p><strong>Google Play Developer Account:</strong> Sumatra Sales Pvt. Ltd.</p>
                        <p><strong>Platform Nature:</strong> Authentic Matrimonial & Matchmaking Service for Legal Adults</p>
                        <p><strong>Head Office:</strong> Ranihati - Amta Road, Ranihati, Howrah, West Bengal - 711322, India</p>
                    </div>
                    <p>
                        <strong>Sumatra Sales Pvt. Ltd.</strong> maintains a zero-tolerance policy against any form of child abuse, child sexual exploitation, or endangerment of minors. We are committed to fostering a safe, strictly adult-verified matrimonial ecosystem in full accordance with the Google Play Child Safety Standards Policy and Indian child protection legislation (including POCSO Act 2012, IT Act 2000, and IT Rules 2021).
                    </p>
                </section>

                <!-- 2. Explicit CSAE & CSAM Zero Tolerance Prohibition -->
                <section class="border-b border-gray-100 pb-8">
                    <div class="bg-red-50 border-l-4 border-red-600 p-5 rounded-r-2xl mb-6 shadow-sm">
                        <h3 class="text-lg font-bold text-red-900 flex items-center gap-2 mb-2">
                            <span>🚫</span> Absolute Prohibition of Child Sexual Abuse and Exploitation (CSAE)
                        </h3>
                        <p class="text-sm text-red-800 leading-relaxed">
                            <strong>Rani Matrimonial</strong> strictly prohibits any creation, possession, transmission, storage, solicitation, or facilitation of <strong>Child Sexual Abuse and Exploitation (CSAE)</strong> and <strong>Child Sexual Abuse Material (CSAM)</strong>. Any user engaging in such behavior faces immediate and irrevocable account termination, device bans, and immediate referral to national and international law enforcement agencies.
                        </p>
                    </div>

                    <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-rani-light/60 text-rani-primary-dark text-sm font-bold shadow-sm border border-rani-gold/20">2</span>
                        Strict Prohibition Standards
                    </h2>
                    <p class="mb-3">Under our platform rules, it is unequivocally forbidden to:</p>
                    <ul class="list-disc pl-6 space-y-2.5">
                        <li>Upload, post, transmit, or share any image, video, audio, text, or graphic depicting, implying, or promoting Child Sexual Abuse Material (CSAM).</li>
                        <li>Attempt to recruit, groom, lure, contact, or sexually solicit any individual who is under 18 years of age (minors).</li>
                        <li>Promote, encourage, facilitate, or normalize child sexual exploitation, child marriages with minors, child trafficking, or pedophilia.</li>
                        <li>Use platform communication channels, profile avatars, public bio fields, or direct messaging to share predatory or harmful content regarding children.</li>
                    </ul>
                </section>

                <!-- 3. Strict Minimum Age Requirement -->
                <section class="border-b border-gray-100 pb-8">
                    <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-rani-light/60 text-rani-primary-dark text-sm font-bold shadow-sm border border-rani-gold/20">3</span>
                        Strict Minimum Age Requirements (No Minors Allowed)
                    </h2>
                    <p class="mb-4">
                        <strong>Rani Matrimonial is strictly restricted to legal adults who are legally eligible for marriage under Indian law.</strong> Minors (individuals under the age of 18) are strictly prohibited from creating accounts, browsing, or utilizing any feature of our platform.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-4">
                        <div class="bg-amber-50 border border-amber-200 p-4 rounded-xl text-center">
                            <span class="block text-2xl font-bold text-amber-900 mb-1">18+ Years</span>
                            <span class="text-xs text-amber-800 uppercase tracking-wider font-semibold">Minimum Age for Women</span>
                            <p class="text-xs text-gray-600 mt-1">Verified via Date of Birth & Government ID</p>
                        </div>
                        <div class="bg-amber-50 border border-amber-200 p-4 rounded-xl text-center">
                            <span class="block text-2xl font-bold text-amber-900 mb-1">21+ Years</span>
                            <span class="text-xs text-amber-800 uppercase tracking-wider font-semibold">Minimum Age for Men</span>
                            <p class="text-xs text-gray-600 mt-1">Verified via Date of Birth & Government ID</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600">
                        Any profile found to be created by or representing a minor will be immediately deleted, and all associated identification artifacts permanently blacklisted.
                    </p>
                </section>

                <!-- 4. Mandatory Identity Verification & Content Moderation -->
                <section class="border-b border-gray-100 pb-8">
                    <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-rani-light/60 text-rani-primary-dark text-sm font-bold shadow-sm border border-rani-gold/20">4</span>
                        Proactive Content Moderation & Verification Mechanisms
                    </h2>
                    <p class="mb-4">
                        To guarantee that our matchmaking service remains safe and protected from bad actors, <strong>Sumatra Sales Pvt. Ltd.</strong> employs robust multilayered moderation mechanisms:
                    </p>
                    <ul class="list-disc pl-6 space-y-2.5">
                        <li><strong>Mandatory Live Selfie Verification:</strong> Every candidate must complete a live selfie verification capture during onboarding to confirm genuine physical identity.</li>
                        <li><strong>Blue-Tick Aadhaar & Government ID Verification:</strong> Rigorous age checks through government identification documents to prevent underage registrations.</li>
                        <li><strong>Automated Media & Text Filtering:</strong> Proactive scanning algorithms evaluate profile photos, bios, and messaging for objectionable keywords, sexualized imagery, and indicators of abuse.</li>
                        <li><strong>Human Trust & Safety Moderation:</strong> Trained human safety specialists review flagged profiles, photo albums, and user reports 24/7 before approval.</li>
                    </ul>
                </section>

                <!-- 5. In-App User Feedback & Reporting Mechanisms -->
                <section class="border-b border-gray-100 pb-8">
                    <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-rani-light/60 text-rani-primary-dark text-sm font-bold shadow-sm border border-rani-gold/20">5</span>
                        In-App Reporting & User Feedback Mechanisms
                    </h2>
                    <p class="mb-4">
                        Users and community members can easily flag and report any suspicious behavior, unauthorized underage profiles, or abusive content using our intuitive reporting tools:
                    </p>
                    <div class="space-y-3">
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl">
                            <h4 class="font-bold text-gray-900 text-sm mb-1">1. In-App "Report Profile" Button:</h4>
                            <p class="text-xs sm:text-sm text-gray-600">Available on every candidate profile view and chat window. Select "Underage / Child Safety Concern" or "Inappropriate Content" to instantly escalate to our safety team.</p>
                        </div>
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl">
                            <h4 class="font-bold text-gray-900 text-sm mb-1">2. Dedicated Safety Help Desk:</h4>
                            <p class="text-xs sm:text-sm text-gray-600">Accessible through the app menu or website under <a href="{{ route('help.center') }}" class="text-rani-primary underline font-medium">Help Center</a>, where priority child safety tickets are addressed within 12 hours.</p>
                        </div>
                    </div>
                </section>

                <!-- 6. Law Enforcement Cooperation & Legal Compliance -->
                <section class="border-b border-gray-100 pb-8">
                    <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-rani-light/60 text-rani-primary-dark text-sm font-bold shadow-sm border border-rani-gold/20">6</span>
                        Law Enforcement Escalation & Compliance with Child Protection Laws
                    </h2>
                    <p class="mb-4">
                        Sumatra Sales Pvt. Ltd. cooperates fully with national and international law enforcement agencies to investigate, prosecute, and eliminate CSAE. Upon detection of any child abuse content or grooming attempt:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-sm text-gray-600">
                        <li>The offending content is immediately expunged from all public and user-facing views while preserving forensic logs.</li>
                        <li>The matter is formally escalated to the <strong>National Cyber Crime Reporting Portal (cybercrime.gov.in)</strong> and relevant state Cyber Crime Police divisions under the POCSO Act.</li>
                        <li>Where applicable, reports are filed with the <strong>National Center for Missing & Exploited Children (NCMEC)</strong> and other statutory bodies.</li>
                    </ul>
                </section>

                <!-- 7. Designated Child Safety Point of Contact -->
                <section class="bg-gradient-to-br from-rani-primary to-rani-primary-dark text-white p-6 sm:p-8 rounded-2xl shadow-xl border border-rani-gold/30">
                    <h2 class="text-xl font-serif font-bold text-rani-gold mb-3 flex items-center gap-2">
                        <span>🛡️</span> 7. Designated Child Safety & Grievance Point of Contact
                    </h2>
                    <p class="text-sm text-rani-gold-light/90 mb-4">
                        For any child safety concerns, immediate CSAE reporting, or regulatory inquiries, contact our designated Child Safety Officer:
                    </p>
                    <div class="text-sm space-y-2 text-gray-100 font-light border-t border-rani-gold/30 pt-4">
                        <p><strong>Designated Point of Contact:</strong> Grievance & Child Safety Officer</p>
                        <p><strong>Operating Entity:</strong> Sumatra Sales Pvt. Ltd. (Sumatra Sales Private Limited)</p>
                        <p><strong>App Name:</strong> Rani Matrimonial</p>
                        <p><strong>Direct Child Safety Email:</strong> <a href="mailto:info.ranimatrimonial@gmail.com" class="text-rani-gold font-medium hover:underline">info.ranimatrimonial@gmail.com</a></p>
                        <p><strong>Corporate Address:</strong> Ranihati - Amta Road, Ranihati, Howrah, West Bengal - 711322, India</p>
                        <p><strong>Response Time Guarantee:</strong> Immediate triage within 4 hours; full resolution within 24 hours.</p>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>
@endsection
