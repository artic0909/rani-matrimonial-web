@extends('frontend.layouts.app')

@section('title', 'Terms & Conditions | Rani Matrimonial - Sumatra Sales Private Limited')

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
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-rani-gold/40 text-rani-gold font-medium text-xs sm:text-sm uppercase tracking-widest mb-4 shadow-lg">
                <span class="w-2 h-2 rounded-full bg-rani-gold animate-ping"></span>
                User Agreement & Service Terms
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-4 tracking-tight drop-shadow-md">
                Terms & Conditions
            </h1>
            <p class="text-base sm:text-lg text-rani-gold-light/90 font-light max-w-2xl mx-auto drop-shadow">
                Please read these terms and conditions carefully before registering or using services offered on <strong class="text-white font-semibold">Rani Matrimonial</strong>, managed by <strong class="text-white font-semibold">Sumatra Sales Private Limited</strong>.
            </p>
            <div class="mt-4 text-xs text-rani-gold-light/60">
                Last Updated & Effective Date: {{ date('F d, Y') }}
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border border-white/60 p-6 sm:p-10 lg:p-12 relative overflow-hidden hover:shadow-rani-gold/10 transition-all duration-500">
            <!-- Top Accent Bar -->
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-90"></div>

            <!-- Document Body -->
            <div class="prose prose-slate max-w-none space-y-10 text-gray-700 leading-relaxed font-sans">

                <!-- 1. Agreement to Terms -->
                <section class="border-b border-gray-100 pb-8">
                    <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-rani-light/60 text-rani-primary-dark text-sm font-bold shadow-sm border border-rani-gold/20">1</span>
                        Contractual Agreement & Operating Entity
                    </h2>
                    <p class="mb-4">
                        This document is an electronic record in terms of the Information Technology Act, 2000 and rules thereunder. This document constitutes a legally binding agreement between you ("User", "Candidate", or "Member") and <strong>Sumatra Sales Private Limited</strong>, the rightful owner and operating company of the brand <strong>Rani Matrimonial</strong> (accessible via <a href="{{ url('/') }}" class="text-rani-primary font-semibold hover:underline">ranimatrimonial.com</a>).
                    </p>
                    <p>
                        By accessing, browsing, registering, or subscribing on our platform, you unequivocally acknowledge that you have read, comprehended, and agreed to be bound by these Terms & Conditions and our Privacy Policy.
                    </p>
                </section>

                <!-- 2. Eligibility & Intended Use -->
                <section class="border-b border-gray-100 pb-8">
                    <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-rani-light/60 text-rani-primary-dark text-sm font-bold shadow-sm border border-rani-gold/20">2</span>
                        Eligibility & Sole Matrimonial Purpose
                    </h2>
                    <p class="mb-4">
                        To register an account or create a matrimonial profile on Rani Matrimonial, you must satisfy the following strict criteria:
                    </p>
                    <ul class="list-disc pl-6 space-y-2.5">
                        <li><strong>Legal Age for Marriage:</strong> You must be of legal marriageable age as per the laws of India (minimum 18 years for females and 21 years for males at the time of registration).</li>
                        <li><strong>Strictly Matrimonial Purpose:</strong> Rani Matrimonial is an exclusive match-making platform created solely to facilitate holy matrimony and lifelong marital unions. <strong>This platform is NOT a dating app, hookup portal, or casual social network.</strong> Profiles found misusing the portal for dating or commercial solicitation will be summarily banned.</li>
                        <li><strong>Marital Capacity:</strong> You must be legally single, divorced (with decree absolute), widowed, or annulled. You must not be legally prohibited from entering into a valid marriage.</li>
                    </ul>
                </section>

                <!-- 3. Account Registration & Verification -->
                <section class="border-b border-gray-100 pb-8">
                    <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-rani-light/60 text-rani-primary-dark text-sm font-bold shadow-sm border border-rani-gold/20">3</span>
                        Profile Authenticity & Verification Process
                    </h2>
                    <p class="mb-4">
                        To maintain the highest level of community trust, Rani Matrimonial enforces a multi-layer verification protocol:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-sm">
                        <li><strong>True & Accurate Information:</strong> You represent and warrant that all information submitted during registration—including age, qualification, employment, salary, marital status, and location—is truthful and authentic.</li>
                        <li><strong>Selfie / Live Face Verification:</strong> Users are prompted to complete a real-time selfie verification to eliminate fake profiles and impersonations.</li>
                        <li><strong>Account Security:</strong> You are responsible for maintaining the confidentiality of your login credentials and OTPs. Any actions performed through your verified account are deemed to be authorized by you.</li>
                    </ul>
                </section>

                <!-- 4. Razorpay Payments, Pricing & Billing -->
                <section class="border-b border-gray-100 pb-8 bg-rani-light/30 -mx-6 sm:-mx-10 p-6 sm:p-10 rounded-2xl border border-rani-gold/30">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-rani-primary text-rani-gold flex items-center justify-center font-bold text-lg shadow-sm">
                            💳
                        </div>
                        <h2 class="text-2xl font-serif font-bold text-rani-primary-dark">
                            4. Payment Terms & Razorpay Gateway Integration
                        </h2>
                    </div>
                    <p class="mb-4 text-gray-800">
                        Rani Matrimonial provides digital value-added services, including paid profile contact unlock credits, wallet top-ups, and premium matchmaking features. All online payment operations are managed in partnership with <strong>Razorpay Software Private Limited</strong>.
                    </p>
                    
                    <div class="space-y-4">
                        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                            <h4 class="font-bold text-rani-primary-dark mb-2">Accepted Payment Modes</h4>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Through Razorpay, we accept all prominent Indian payment instruments: UPI (Google Pay, PhonePe, Paytm, BHIM), Net Banking (over 50+ major Indian banks), Credit Cards (Visa, MasterCard, RuPay, Diners), Debit Cards, and leading mobile wallets.
                            </p>
                        </div>

                        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                            <h4 class="font-bold text-rani-primary-dark mb-2">Currency & Taxation</h4>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                All charges and credit amounts are listed in <strong>Indian National Rupees (INR ₹)</strong> and are inclusive/exclusive of applicable Goods and Services Tax (GST) as specified at the point of checkout. Invoices are generated under the name of <strong>Sumatra Sales Private Limited</strong>.
                            </p>
                        </div>

                        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                            <h4 class="font-bold text-rani-primary-dark mb-2">Payment Security Guarantee</h4>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                All transactions are conducted over high-grade 256-bit encrypted channels directly on Razorpay's PCI-DSS compliant infrastructure. Sumatra Sales Private Limited does not store or process sensitive payment credentials.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- 5. Cancellation & Refund Policy -->
                <section class="border-b border-gray-100 pb-8">
                    <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-rani-light/60 text-rani-primary-dark text-sm font-bold shadow-sm border border-rani-gold/20">5</span>
                        Cancellation & Refund Policy
                    </h2>
                    <div class="bg-amber-50/70 border border-amber-200 p-5 rounded-xl mb-4 text-sm text-amber-900 shadow-sm">
                        <p class="font-semibold mb-1">Notice on Digital Content & Immediate Service Provision:</p>
                        <p>Since services on Rani Matrimonial consist of immediate digital access, profile views, and instant contact credits, standard physical goods return rules do not apply.</p>
                    </div>
                    <ul class="list-disc pl-6 space-y-2.5 text-sm">
                        <li><strong>Non-Refundable Upon Consumption:</strong> Fees paid for wallet top-ups, unlocked profile contacts, or membership subscriptions are strictly non-refundable once the digital credits have been utilized or activated on the account.</li>
                        <li><strong>Failed / Duplicate Transactions:</strong> If your bank account or UPI was debited but the wallet credit was not credited due to technical interruption, Razorpay and the banking network will automatically reconcile and refund the amount back to the original payment source within <strong>5 to 7 business banking days</strong>.</li>
                        <li><strong>Refund Inquiries:</strong> In exceptional scenarios involving proven technical failure or erroneous double-billing, members may write to <a href="mailto:info.ranimatrimonial@gmail.com" class="text-rani-primary font-semibold hover:underline">info.ranimatrimonial@gmail.com</a> with transaction IDs within 48 hours of payment.</li>
                    </ul>
                </section>

                <!-- 6. Code of Conduct & Prohibited Acts -->
                <section class="border-b border-gray-100 pb-8">
                    <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-rani-light/60 text-rani-primary-dark text-sm font-bold shadow-sm border border-rani-gold/20">6</span>
                        Community Guidelines & Prohibited Conduct
                    </h2>
                    <p class="mb-3 text-sm">
                        Users strictly agree <strong>NOT</strong> to engage in any of the following activities:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-sm text-gray-600">
                        <li>Harassing, stalking, abusing, defrauding, or demanding money/financial aid from any other member.</li>
                        <li>Uploading obscene, defamatory, misleading, copyrighted, or inappropriate photographs and text.</li>
                        <li>Creating duplicate or fraudulent profiles using photographs or identities of others.</li>
                        <li>Using automated bots, scrapers, or software to crawl or harvest candidate bio-data.</li>
                    </ul>
                    <p class="mt-3 text-xs text-red-600 font-semibold">
                        Violation of community guidelines will result in immediate profile termination without notice and potential referral to cyber law enforcement.
                    </p>
                </section>

                <!-- 7. Disclaimer of Liability & Member Verification Advisory -->
                <section class="border-b border-gray-100 pb-8">
                    <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-rani-light/60 text-rani-primary-dark text-sm font-bold shadow-sm border border-rani-gold/20">7</span>
                        Disclaimer of Liability & User Due Diligence
                    </h2>
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-sm leading-relaxed text-gray-700 space-y-3 shadow-sm">
                        <p>
                            <strong>Sumatra Sales Private Limited</strong> acts as an intermediary matchmaking platform under Section 79 of the Information Technology Act, 2000. While we perform stringent screening and selfie verification, we strongly advise all members and their families to conduct <u>independent background, financial, family, and character verifications</u> before finalizing any marriage alliance.
                        </p>
                        <p>
                            Sumatra Sales Private Limited shall not be held liable for any personal, emotional, marital, or financial disputes arising between members outside the scope of platform facilitation.
                        </p>
                    </div>
                </section>

                <!-- 8. Intellectual Property -->
                <section class="border-b border-gray-100 pb-8">
                    <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-rani-light/60 text-rani-primary-dark text-sm font-bold shadow-sm border border-rani-gold/20">8</span>
                        Intellectual Property Rights
                    </h2>
                    <p class="text-sm">
                        All logos, graphics, icons, software, algorithms, brand assets, and content on <a href="{{ url('/') }}" class="text-rani-primary font-semibold hover:underline">ranimatrimonial.com</a> are the sole intellectual property of <strong>Sumatra Sales Private Limited</strong> and are protected under Indian and International Trademark & Copyright laws.
                    </p>
                </section>

                <!-- 9. Governing Law & Jurisdiction -->
                <section class="border-b border-gray-100 pb-8">
                    <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-rani-light/60 text-rani-primary-dark text-sm font-bold shadow-sm border border-rani-gold/20">9</span>
                        Governing Law & Legal Jurisdiction
                    </h2>
                    <p class="text-sm">
                        These Terms & Conditions shall be construed and governed in accordance with the laws of the Republic of India. Any dispute, controversy, or claim arising out of or relating to these terms shall be subject to the exclusive jurisdiction of the competent courts in <strong>West Bengal, India</strong>.
                    </p>
                </section>

                <!-- 10. Contact & Redressal -->
                <section class="bg-gradient-to-br from-rani-primary to-rani-primary-dark text-white p-6 sm:p-8 rounded-2xl shadow-xl border border-rani-gold/30">
                    <h2 class="text-xl font-serif font-bold text-rani-gold mb-3 flex items-center gap-2">
                        <span>🏛️</span> 10. Customer Support & Corporate Information
                    </h2>
                    <p class="text-sm text-rani-gold-light/90 mb-4">
                        For any questions regarding these Terms & Conditions, transactions, or account verification, please reach out to our team:
                    </p>
                    <div class="text-sm space-y-1.5 text-gray-100 font-light border-t border-rani-gold/30 pt-4">
                        <p><strong>Operating Company:</strong> Sumatra Sales Private Limited</p>
                        <p><strong>Brand / Platform:</strong> Rani Matrimonial</p>
                        <p><strong>Customer Support:</strong> <a href="mailto:info.ranimatrimonial@gmail.com" class="text-rani-gold font-medium hover:underline">info.ranimatrimonial@gmail.com</a></p>
                        <p><strong>Country of Operation:</strong> India</p>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>
@endsection
