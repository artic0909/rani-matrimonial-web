@extends('frontend.layouts.app')

@section('title', 'Privacy Policy | Rani Matrimonial - Sumatra Sales Private Limited')

@section('content')
<div class="relative bg-gradient-to-b from-rani-light via-white to-rani-light/40 py-16 px-4 sm:px-6 lg:px-8">
    <!-- Hero Banner -->
    <div class="max-w-4xl mx-auto text-center mb-12">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-rani-primary/10 border border-rani-gold/30 text-rani-primary-dark font-medium text-xs sm:text-sm uppercase tracking-wider mb-4">
            <span class="w-2 h-2 rounded-full bg-rani-gold animate-pulse"></span>
            Legal & Data Protection
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-rani-primary-dark mb-4 tracking-tight">
            Privacy Policy
        </h1>
        <p class="text-base sm:text-lg text-gray-600 font-light max-w-2xl mx-auto">
            Your trust and privacy are sacred to us. Learn how <strong class="text-gray-800 font-semibold">Rani Matrimonial</strong> (an initiative of <strong class="text-gray-800 font-semibold">Sumatra Sales Private Limited</strong>) collects, safeguards, and handles your personal information.
        </p>
        <div class="mt-4 text-xs text-gray-500">
            Last Updated & Effective Date: {{ date('F d, Y') }}
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-100 p-6 sm:p-10 lg:p-12 relative overflow-hidden">
        <!-- Top Accent Bar -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold"></div>

        <!-- Document Body -->
        <div class="prose prose-slate max-w-none space-y-10 text-gray-700 leading-relaxed font-sans">

            <!-- 1. Introduction -->
            <section class="border-b border-gray-100 pb-8">
                <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-rani-light text-rani-primary text-sm font-bold">1</span>
                    Introduction & Corporate Overview
                </h2>
                <p class="mb-4">
                    Welcome to <strong>Rani Matrimonial</strong> (<a href="{{ url('/') }}" class="text-rani-primary font-semibold hover:underline">ranimatrimonial.com</a>), a premier matrimonial and match-making platform operated, owned, and governed exclusively by <strong>Sumatra Sales Private Limited</strong> ("Company", "we", "our", or "us").
                </p>
                <p>
                    We are dedicated to safeguarding your personal details and creating a secure, trustworthy space for matrimonial alliances. This Privacy Policy clarifies our procedures concerning the collection, storage, verification, transmission, and protection of your personal and sensitive data when you access or use our website and associated applications.
                </p>
            </section>

            <!-- 2. Information We Collect -->
            <section class="border-b border-gray-100 pb-8">
                <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-rani-light text-rani-primary text-sm font-bold">2</span>
                    Information We Collect
                </h2>
                <p class="mb-4">
                    To deliver accurate matchmaking recommendations and maintain community integrity, we collect the following categories of information:
                </p>
                <ul class="list-disc pl-6 space-y-2.5">
                    <li><strong>Account & Contact Data:</strong> Full name, verified mobile number, email address, date of birth, gender, and password/authentication tokens.</li>
                    <li><strong>Identity & Verification Data:</strong> Live selfie verification capture, identity authentication artifacts, and police station jurisdiction for background security.</li>
                    <li><strong>Matrimonial & Demographic Details:</strong> Religion, community, sub-community, caste/gotram, mother tongue, marital status, height, diet, and lifestyle habits.</li>
                    <li><strong>Educational & Professional Details:</strong> Highest academic qualification, college/university, current profession, employer/company, and annual income bracket.</li>
                    <li><strong>Location & Address:</strong> Residential country, state, city, police station, pincode, residency status, and full address.</li>
                    <li><strong>Horoscope / Astrological Information:</strong> Manglik status, time of birth, and city of birth (provided voluntarily by candidate).</li>
                    <li><strong>Photographs & Visual Media:</strong> Profile photos, avatar selfies, and album gallery pictures uploaded by you under your chosen privacy visibility tier.</li>
                </ul>
            </section>

            <!-- 3. Razorpay & Payment Gateway Security -->
            <section class="border-b border-gray-100 pb-8 bg-rani-light/30 -mx-6 sm:-mx-10 p-6 sm:p-10 rounded-2xl border border-rani-gold/30">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 rounded-xl bg-rani-primary text-rani-gold flex items-center justify-center font-bold text-lg">
                        💳
                    </div>
                    <h2 class="text-2xl font-serif font-bold text-rani-primary-dark">
                        3. Payment Information & Razorpay Security Assurance
                    </h2>
                </div>
                <p class="mb-4 text-gray-800">
                    When you purchase wallet top-ups, premium memberships, or paid contact credits, financial transactions are processed securely through our trusted payment gateway partner, <strong>Razorpay Software Private Limited</strong>.
                </p>
                <div class="space-y-3 bg-white p-5 rounded-xl border border-gray-200">
                    <div class="flex items-start gap-3">
                        <span class="text-green-600 font-bold">✓</span>
                        <p class="text-sm"><strong>Zero Card/Bank Storage:</strong> Rani Matrimonial and Sumatra Sales Private Limited <u>NEVER</u> store, record, or retain your credit card number, debit card number, CVV code, UPI PIN, or net banking credentials on our servers.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-green-600 font-bold">✓</span>
                        <p class="text-sm"><strong>PCI-DSS Level 1 Compliance:</strong> All payment sessions are encrypted with industry-standard 256-bit SSL encryption and routed directly through Razorpay’s certified PCI-DSS Level 1 secure payment environment.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-green-600 font-bold">✓</span>
                        <p class="text-sm"><strong>Transaction Logs:</strong> We solely receive and store transaction verification references (such as Razorpay Payment ID, Order ID, timestamp, and transaction status) to credit your matrimonial wallet and issue digital receipts.</p>
                    </div>
                </div>
            </section>

            <!-- 4. How We Use Your Information -->
            <section class="border-b border-gray-100 pb-8">
                <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-rani-light text-rani-primary text-sm font-bold">4</span>
                    How We Use Your Information
                </h2>
                <ul class="list-disc pl-6 space-y-2">
                    <li>To verify authenticity and establish genuine candidate profiles.</li>
                    <li>To compute astrological and demographic match percentages.</li>
                    <li>To display candidate bio-data to prospective matches according to your explicit privacy configuration.</li>
                    <li>To process wallet credits and manage transactions via Razorpay.</li>
                    <li>To send critical account notifications, match recommendations, OTPs, and customer assistance updates.</li>
                    <li>To protect the platform against fraud, impersonation, romance scams, and unauthorized commercial misuse.</li>
                </ul>
            </section>

            <!-- 5. User Privacy Controls -->
            <section class="border-b border-gray-100 pb-8">
                <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-rani-light text-rani-primary text-sm font-bold">5</span>
                    Candidate Privacy & Granular Controls
                </h2>
                <p class="mb-4">
                    At Rani Matrimonial, you maintain full authority over what information is revealed and to whom:
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <h4 class="font-bold text-gray-800 mb-1">📷 Photo & Album Privacy</h4>
                        <p class="text-gray-600">Choose between "Visible to all Members", "Visible only to Members I like / Premium Members", or "Protected Album".</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <h4 class="font-bold text-gray-800 mb-1">📞 Contact Display Options</h4>
                        <p class="text-gray-600">Choose whether your contact number is visible to all verified premium members, or only upon mutually accepted interest.</p>
                    </div>
                </div>
            </section>

            <!-- 6. Data Sharing & Non-Disclosure -->
            <section class="border-b border-gray-100 pb-8">
                <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-rani-light text-rani-primary text-sm font-bold">6</span>
                    Information Sharing & Non-Disclosure
                </h2>
                <p class="mb-3">
                    <strong>We do NOT sell, rent, monetize, or trade your personal data to third-party marketing agencies.</strong>
                </p>
                <p class="text-sm text-gray-600">
                    Information is shared only under strict conditions:
                </p>
                <ul class="list-disc pl-6 space-y-1.5 text-sm text-gray-600 mt-2">
                    <li>With prospective matches as dictated by your active profile visibility rules.</li>
                    <li>With trusted service providers (SMS gateways, Razorpay payment gateway, cloud hosting) solely for operational service delivery under binding confidentiality.</li>
                    <li>When mandated by applicable Indian laws, judicial orders, or law enforcement authorities.</li>
                </ul>
            </section>

            <!-- 7. Data Retention & Deletion -->
            <section class="border-b border-gray-100 pb-8">
                <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-rani-light text-rani-primary text-sm font-bold">7</span>
                    Data Retention & Account Deactivation
                </h2>
                <p>
                    You may update your profile data at any time via your candidate dashboard. If you find your partner or wish to remove your account, you can request profile deactivation or permanent deletion. Upon deactivation, your profile will immediately become invisible to all platform searches.
                </p>
            </section>

            <!-- 8. Grievance Officer & Contact Details -->
            <section class="bg-rani-primary text-white p-6 sm:p-8 rounded-2xl">
                <h2 class="text-xl font-serif font-bold text-rani-gold mb-3">
                    8. Grievance Redressal & Contact Information
                </h2>
                <p class="text-sm text-rani-gold-light/90 mb-4">
                    In compliance with the Information Technology Act 2000 and the Digital Personal Data Protection laws of India, any queries or grievances concerning personal data may be submitted to our designated officer:
                </p>
                <div class="text-sm space-y-1.5 text-gray-100 font-light border-t border-rani-gold/30 pt-4">
                    <p><strong>Entity:</strong> Sumatra Sales Private Limited</p>
                    <p><strong>Brand:</strong> Rani Matrimonial</p>
                    <p><strong>Grievance Officer:</strong> Data Protection & Grievance Department</p>
                    <p><strong>Official Email:</strong> <a href="mailto:info.ranimatrimonial@gmail.com" class="text-rani-gold font-medium hover:underline">info.ranimatrimonial@gmail.com</a></p>
                    <p><strong>Country:</strong> India</p>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection
