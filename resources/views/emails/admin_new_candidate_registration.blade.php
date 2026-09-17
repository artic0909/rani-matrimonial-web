<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Candidate Registration - Rani Matrimonial</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f5eee6;
            font-family: 'Outfit', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1a0000;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            background-color: #f5eee6;
            padding: 36px 12px;
        }
        .email-container {
            max-width: 620px;
            margin: 0 auto;
            background-color: #fdfbf7;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(74, 4, 4, 0.12);
            border: 1px solid rgba(212, 175, 55, 0.35);
        }
        .header {
            background: linear-gradient(135deg, #4a0404 0%, #750000 55%, #3b0000 100%);
            padding: 32px 24px;
            text-align: center;
            color: #ffffff;
            border-bottom: 3px solid #d4af37;
            position: relative;
        }
        .header-logo-container {
            margin-bottom: 14px;
            display: inline-block;
        }
        .header-logo {
            max-height: 60px;
            max-width: 200px;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 10px;
            display: inline-block;
        }
        .header-badge {
            display: inline-block;
            background: rgba(212, 175, 55, 0.18);
            border: 1px solid #d4af37;
            color: #f9f1d8;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 4px 16px;
            border-radius: 20px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0 0 6px 0;
            font-size: 23px;
            font-weight: 700;
            color: #fdfbf7;
            font-family: 'Playfair Display', Georgia, serif;
            letter-spacing: 0.5px;
        }
        .header p {
            margin: 0;
            font-size: 13px;
            color: #f9f1d8;
            opacity: 0.92;
        }
        .content {
            padding: 28px 24px;
        }
        
        /* Candidate Quick Identity Card */
        .hero-candidate-box {
            background: linear-gradient(135deg, #ffffff 0%, #fcf7ed 100%);
            border: 1.5px solid rgba(212, 175, 55, 0.45);
            border-left: 5px solid #750000;
            border-radius: 14px;
            padding: 18px 20px;
            margin-bottom: 24px;
            box-shadow: 0 3px 12px rgba(117, 0, 0, 0.04);
        }
        .hero-candidate-name {
            font-size: 20px;
            font-weight: 700;
            color: #4a0404;
            font-family: 'Playfair Display', Georgia, serif;
            margin: 0 0 4px 0;
        }
        .code-badge {
            display: inline-block;
            background-color: #750000;
            color: #d4af37;
            border: 1px solid #d4af37;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 6px;
            margin-right: 6px;
        }
        
        /* Branch Referral Highlight Box */
        .branch-highlight-box {
            background: linear-gradient(135deg, #fffdf8 0%, #fef8eb 100%);
            border: 1.5px solid #d4af37;
            border-left: 5px solid #c59b27;
            border-radius: 14px;
            padding: 18px 20px;
            margin-bottom: 24px;
            box-shadow: 0 4px 14px rgba(212, 175, 55, 0.12);
        }
        .branch-highlight-title {
            font-size: 13px;
            font-weight: 800;
            color: #750000;
            margin: 0 0 12px 0;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1px dashed rgba(212, 175, 55, 0.5);
            padding-bottom: 6px;
        }
        .branch-code-pill {
            display: inline-block;
            background: linear-gradient(135deg, #750000 0%, #4a0404 100%);
            color: #d4af37;
            border: 1px solid #d4af37;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 6px;
            letter-spacing: 0.5px;
        }

        .section-title {
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #750000;
            margin: 24px 0 12px 0;
            padding-bottom: 6px;
            border-bottom: 1.5px solid rgba(212, 175, 55, 0.4);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .info-table td {
            padding: 9px 12px;
            font-size: 13px;
            vertical-align: top;
        }
        .info-table tr:nth-child(even) {
            background-color: #f7efe4;
            border-radius: 8px;
        }
        .info-label {
            width: 38%;
            color: #78350f;
            font-weight: 600;
        }
        .info-val {
            width: 62%;
            color: #3b0000;
            font-weight: 600;
        }
        
        /* Royal Gold Action CTA */
        .btn-action {
            display: block;
            width: fit-content;
            margin: 30px auto 10px auto;
            background: linear-gradient(135deg, #d4af37 0%, #c59b27 50%, #b8860b 100%);
            color: #3b0000 !important;
            text-decoration: none;
            padding: 14px 34px;
            font-size: 14px;
            font-weight: 800;
            border-radius: 9999px;
            text-align: center;
            box-shadow: 0 5px 18px rgba(212, 175, 55, 0.35);
            border: 1px solid #f9f1d8;
            letter-spacing: 0.3px;
        }
        
        /* Royal Footer */
        .footer {
            background: linear-gradient(135deg, #f9f1d8 0%, #f4e8c5 100%);
            padding: 22px 24px;
            text-align: center;
            border-top: 1.5px solid rgba(212, 175, 55, 0.4);
            font-size: 12px;
            color: #5c0a0a;
        }
        .footer a {
            color: #750000;
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="email-container">
            
            <!-- Email Header Banner with Logo & Royal Maroon Gradient -->
            <div class="header">
                
                <!-- Brand Logo -->
                <div class="header-logo-container">
                    @php
                        $logoPath = public_path('logo.png');
                        $hasLogo = file_exists($logoPath);
                        $logoSrc = (isset($message) && $hasLogo) ? $message->embed($logoPath) : asset('logo.png');
                    @endphp
                    <img src="{{ $logoSrc }}" alt="Rani Matrimonial Logo" class="header-logo">
                </div>

                <div>
                    <div class="header-badge">Admin Registration Alert</div>
                    <h1>New Candidate Registration</h1>
                    <p>A new matrimony profile has joined the Rani Matrimonial platform</p>
                </div>
            </div>

            <!-- Email Body Content -->
            <div class="content">
                
                <!-- Candidate Quick Identity Card -->
                <div class="hero-candidate-box">
                    <div class="hero-candidate-name">
                        {{ $candidate->first_name }} {{ $candidate->last_name }}
                    </div>
                    <div style="font-size: 13px; color: #78350f; margin-top: 6px;">
                        <span class="code-badge">{{ $candidate->display_code }}</span>
                        <strong>{{ $candidate->gender ?? 'N/A' }}</strong>
                        @if($candidate->dob)
                            <span> • {{ \Carbon\Carbon::parse($candidate->dob)->age }} Yrs</span>
                        @endif
                        <span> • {{ $candidate->religion ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- SPECIAL BRANCH REFERRAL DETAILS (If Candidate Registered via Branch Referral Code) -->
                @if($branch)
                    <div class="branch-highlight-box">
                        <div class="branch-highlight-title">
                            🏢 Onboarded via Branch Franchise Referral
                        </div>
                        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                            <tr>
                                <td style="width: 38%; color: #78350f; font-weight: 600; padding: 5px 0;">Branch Referral Code:</td>
                                <td style="width: 62%; color: #3b0000; font-weight: 700; padding: 5px 0;">
                                    <span class="branch-code-pill">{{ $branch->code }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 38%; color: #78350f; font-weight: 600; padding: 5px 0;">Branch / Center Name:</td>
                                <td style="width: 62%; color: #750000; font-weight: 800; padding: 5px 0;">
                                    {{ $branch->name }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 38%; color: #78350f; font-weight: 600; padding: 5px 0;">Manager & Designation:</td>
                                <td style="width: 62%; color: #3b0000; font-weight: 600; padding: 5px 0;">
                                    {{ $branch->designation ?? 'Branch Manager' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 38%; color: #78350f; font-weight: 600; padding: 5px 0;">Contact Mobile:</td>
                                <td style="width: 62%; color: #750000; font-weight: 700; padding: 5px 0;">
                                    <a href="tel:{{ $branch->phone }}" style="color: #750000; text-decoration: none; font-weight: 800;">
                                        {{ $branch->phone }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 38%; color: #78350f; font-weight: 600; padding: 5px 0;">Branch City / State:</td>
                                <td style="width: 62%; color: #3b0000; font-weight: 600; padding: 5px 0;">
                                    {{ $branch->city }}, {{ $branch->state }}
                                </td>
                            </tr>
                            @if($branch->full_address)
                            <tr>
                                <td style="width: 38%; color: #78350f; font-weight: 600; padding: 5px 0;">Full Physical Address:</td>
                                <td style="width: 62%; color: #4a0404; font-weight: 500; padding: 5px 0; white-space: pre-line;">
                                    {{ $branch->full_address }}
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="2" style="padding-top: 12px;">
                                    <a href="{{ url('/admin/branches/' . $branch->id) }}" style="color: #750000; font-weight: 800; font-size: 12px; text-decoration: underline;">
                                        View Branch Referral Register & Analytics →
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif

                <!-- 1. Primary Contact & Personal Details -->
                <div class="section-title">👤 Personal & Contact Info</div>
                <table class="info-table">
                    <tr>
                        <td class="info-label">Full Name:</td>
                        <td class="info-val">{{ $candidate->first_name }} {{ $candidate->last_name }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Candidate Code / Profile ID:</td>
                        <td class="info-val"><strong style="color: #750000;">{{ $candidate->display_code }}</strong></td>
                    </tr>
                    <tr>
                        <td class="info-label">Mobile Number:</td>
                        <td class="info-val">
                            <a href="tel:{{ $candidate->mobile }}" style="color: #750000; text-decoration: none; font-weight: 800;">
                                +91 {{ $candidate->mobile }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Email Address:</td>
                        <td class="info-val">
                            <a href="mailto:{{ $candidate->email }}" style="color: #750000; text-decoration: none; font-weight: 600;">
                                {{ $candidate->email }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Profile Created For:</td>
                        <td class="info-val">{{ $candidate->profile_for ?? 'Self' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Date of Birth / Age:</td>
                        <td class="info-val">
                            {{ $candidate->dob ? \Carbon\Carbon::parse($candidate->dob)->format('d M, Y') : 'N/A' }}
                            @if($candidate->dob)
                                ({{ \Carbon\Carbon::parse($candidate->dob)->age }} years old)
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Marital Status:</td>
                        <td class="info-val">{{ $candidate->marital_status ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Height / Diet:</td>
                        <td class="info-val">{{ $candidate->height ?? 'N/A' }} | {{ $candidate->diet ?? 'N/A' }}</td>
                    </tr>
                </table>

                <!-- 2. Religious & Community Background -->
                <div class="section-title">🕊️ Religion & Community</div>
                <table class="info-table">
                    <tr>
                        <td class="info-label">Religion:</td>
                        <td class="info-val">{{ $candidate->religion ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Community / Caste:</td>
                        <td class="info-val">{{ $candidate->community ?? 'N/A' }} {{ $candidate->sub_community ? '('.$candidate->sub_community.')' : '' }}</td>
                    </tr>
                    @if($candidate->mother_tongue)
                    <tr>
                        <td class="info-label">Mother Tongue:</td>
                        <td class="info-val">{{ $candidate->mother_tongue }}</td>
                    </tr>
                    @endif
                </table>

                <!-- 3. Location & Address -->
                <div class="section-title">📍 Location Details</div>
                <table class="info-table">
                    <tr>
                        <td class="info-label">City, State:</td>
                        <td class="info-val"><strong style="color: #750000;">{{ $candidate->city ?? 'N/A' }}, {{ $candidate->state ?? 'N/A' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="info-label">Country:</td>
                        <td class="info-val">{{ $candidate->country ?? 'India' }}</td>
                    </tr>
                    @if($candidate->pincode || $candidate->police_st)
                    <tr>
                        <td class="info-label">Pincode / Police Station:</td>
                        <td class="info-val">{{ $candidate->pincode ?? 'N/A' }} | {{ $candidate->police_st ?? 'N/A' }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="info-label">Full Address:</td>
                        <td class="info-val" style="white-space: pre-line;">{{ $candidate->full_address ?? 'N/A' }}</td>
                    </tr>
                </table>

                <!-- 4. Education & Profession -->
                <div class="section-title">🎓 Education & Career</div>
                <table class="info-table">
                    <tr>
                        <td class="info-label">Highest Qualification:</td>
                        <td class="info-val">{{ $candidate->highest_qualification ?? 'N/A' }}</td>
                    </tr>
                    @if($candidate->college_name)
                    <tr>
                        <td class="info-label">College / University:</td>
                        <td class="info-val">{{ $candidate->college_name }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="info-label">Profession / Role:</td>
                        <td class="info-val"><strong style="color: #750000;">{{ $candidate->profession ?? 'N/A' }}</strong> ({{ $candidate->designation ?? 'N/A' }})</td>
                    </tr>
                    <tr>
                        <td class="info-label">Working With / Income:</td>
                        <td class="info-val">{{ $candidate->working_with ?? 'N/A' }} | Annual: <strong style="color: #750000;">{{ $candidate->annual_income ?? 'N/A' }}</strong></td>
                    </tr>
                    @if($candidate->company_name)
                    <tr>
                        <td class="info-label">Company Name:</td>
                        <td class="info-val">{{ $candidate->company_name }}</td>
                    </tr>
                    @endif
                </table>

                <!-- 5. Verification & Referral Summary -->
                <div class="section-title">🛡️ KYC & Registration Details</div>
                <table class="info-table">
                    <tr>
                        <td class="info-label">Aadhaar Number:</td>
                        <td class="info-val"><strong style="letter-spacing: 0.8px; color: #750000;">{{ $candidate->aadhar_number ?? 'N/A' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="info-label">Selfie Verification:</td>
                        <td class="info-val">
                            @if($candidate->selfie_verified)
                                <span style="color: #16a34a; font-weight: 800;">✓ Selfie Uploaded & Verified</span>
                            @else
                                <span style="color: #dc2626; font-weight: 700;">✗ Not Verified</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Registration Mode:</td>
                        <td class="info-val">
                            @if($branch)
                                <strong style="color: #750000;">Branch Franchise: {{ $branch->name }} ({{ $branch->code }})</strong>
                            @else
                                <span style="color: #78350f; font-weight: 600;">Direct Website Registration</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Registration Time:</td>
                        <td class="info-val">{{ $candidate->created_at ? $candidate->created_at->format('d M, Y h:i A') : now()->format('d M, Y h:i A') }}</td>
                    </tr>
                </table>

                <!-- Admin Action Button -->
                <a href="{{ url('/admin/candidates/' . $candidate->id) }}" class="btn-action">
                    Inspect Profile in Admin Dashboard →
                </a>

            </div>

            <!-- Royal Footer -->
            <div class="footer">
                <p style="margin: 0 0 6px 0; font-weight: 600;">This is an automated administrative notification from <strong>Rani Matrimonial</strong>.</p>
                <p style="margin: 0; font-size: 11px; opacity: 0.85;">© {{ date('Y') }} Rani Matrimonial. All rights reserved.</p>
            </div>

        </div>
    </div>
</body>
</html>
