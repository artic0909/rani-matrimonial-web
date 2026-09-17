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
            background-color: #f4f7f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            background-color: #f4f7f5;
            padding: 30px 10px;
        }
        .email-container {
            max-width: 620px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: linear-gradient(135deg, #0F4A32 0%, #176B49 100%);
            padding: 30px 24px;
            text-align: center;
            color: #ffffff;
        }
        .header-badge {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 4px 14px;
            border-radius: 20px;
            margin-bottom: 12px;
        }
        .header h1 {
            margin: 0 0 6px 0;
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.3px;
        }
        .header p {
            margin: 0;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.85);
        }
        .content {
            padding: 28px 24px;
        }
        .hero-candidate-box {
            background: linear-gradient(135deg, #f8faf9 0%, #ffffff 100%);
            border: 1px solid #e0eae4;
            border-left: 4px solid #0F4A32;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
        }
        .hero-candidate-name {
            font-size: 18px;
            font-weight: 700;
            color: #0F4A32;
            margin: 0 0 4px 0;
        }
        .code-badge {
            display: inline-block;
            background-color: #0F4A32;
            color: #ffffff;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            margin-right: 6px;
        }
        
        /* Branch Referral Highlight Box */
        .branch-highlight-box {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 1.5px solid #86efac;
            border-left: 5px solid #16a34a;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
        }
        .branch-highlight-title {
            font-size: 14px;
            font-weight: 700;
            color: #15803d;
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .branch-code-pill {
            display: inline-block;
            background-color: #15803d;
            color: #ffffff;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 6px;
            letter-spacing: 0.5px;
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #0F4A32;
            margin: 22px 0 12px 0;
            padding-bottom: 6px;
            border-bottom: 1.5px solid #eef2f0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .info-table td {
            padding: 8px 10px;
            font-size: 13px;
            vertical-align: top;
        }
        .info-table tr:nth-child(even) {
            background-color: #f8faf9;
            border-radius: 6px;
        }
        .info-label {
            width: 38%;
            color: #64748b;
            font-weight: 600;
        }
        .info-val {
            width: 62%;
            color: #1e293b;
            font-weight: 600;
        }
        .btn-action {
            display: block;
            width: fit-content;
            margin: 28px auto 10px auto;
            background: linear-gradient(135deg, #0F4A32 0%, #176B49 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            font-size: 14px;
            font-weight: 700;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(15, 74, 50, 0.25);
        }
        .footer {
            background-color: #f8faf9;
            padding: 20px 24px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #94a3b8;
        }
        .footer a {
            color: #0F4A32;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="email-container">
            
            <!-- Email Header Banner -->
            <div class="header">
                <div class="header-badge">Admin Notification</div>
                <h1>New Candidate Registration</h1>
                <p>A new matrimony profile has been registered on Rani Matrimonial</p>
            </div>

            <!-- Email Body Content -->
            <div class="content">
                
                <!-- Candidate Quick Identity Card -->
                <div class="hero-candidate-box">
                    <div class="hero-candidate-name">
                        {{ $candidate->first_name }} {{ $candidate->last_name }}
                    </div>
                    <div style="font-size: 13px; color: #475569; margin-top: 4px;">
                        <span class="code-badge">{{ $candidate->display_code }}</span>
                        <span>{{ $candidate->gender ?? 'N/A' }}</span>
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
                                <td style="width: 38%; color: #166534; font-weight: 600; padding: 4px 0;">Branch Code:</td>
                                <td style="width: 62%; color: #14532d; font-weight: 700; padding: 4px 0;">
                                    <span class="branch-code-pill">{{ $branch->code }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 38%; color: #166534; font-weight: 600; padding: 4px 0;">Branch Name:</td>
                                <td style="width: 62%; color: #14532d; font-weight: 700; padding: 4px 0;">
                                    {{ $branch->name }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 38%; color: #166534; font-weight: 600; padding: 4px 0;">Manager / Role:</td>
                                <td style="width: 62%; color: #14532d; font-weight: 600; padding: 4px 0;">
                                    {{ $branch->designation ?? 'Branch Manager' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 38%; color: #166534; font-weight: 600; padding: 4px 0;">Contact Phone:</td>
                                <td style="width: 62%; color: #14532d; font-weight: 700; padding: 4px 0;">
                                    <a href="tel:{{ $branch->phone }}" style="color: #15803d; text-decoration: none;">
                                        {{ $branch->phone }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 38%; color: #166534; font-weight: 600; padding: 4px 0;">Location:</td>
                                <td style="width: 62%; color: #14532d; font-weight: 600; padding: 4px 0;">
                                    {{ $branch->city }}, {{ $branch->state }}
                                </td>
                            </tr>
                            @if($branch->full_address)
                            <tr>
                                <td style="width: 38%; color: #166534; font-weight: 600; padding: 4px 0;">Office Address:</td>
                                <td style="width: 62%; color: #14532d; font-weight: 500; padding: 4px 0; white-space: pre-line;">
                                    {{ $branch->full_address }}
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="2" style="padding-top: 10px;">
                                    <a href="{{ url('/admin/branches/' . $branch->id) }}" style="color: #15803d; font-weight: 700; font-size: 12px; text-decoration: underline;">
                                        View Branch Dashboard & Referrals Register →
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
                        <td class="info-val"><strong>{{ $candidate->display_code }}</strong></td>
                    </tr>
                    <tr>
                        <td class="info-label">Mobile Number:</td>
                        <td class="info-val">
                            <a href="tel:{{ $candidate->mobile }}" style="color: #0F4A32; text-decoration: none; font-weight: 700;">
                                +91 {{ $candidate->mobile }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Email Address:</td>
                        <td class="info-val">
                            <a href="mailto:{{ $candidate->email }}" style="color: #0F4A32; text-decoration: none;">
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
                        <td class="info-val"><strong>{{ $candidate->city ?? 'N/A' }}, {{ $candidate->state ?? 'N/A' }}</strong></td>
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
                        <td class="info-val"><strong>{{ $candidate->profession ?? 'N/A' }}</strong> ({{ $candidate->designation ?? 'N/A' }})</td>
                    </tr>
                    <tr>
                        <td class="info-label">Working With / Income:</td>
                        <td class="info-val">{{ $candidate->working_with ?? 'N/A' }} | Annual: <strong>{{ $candidate->annual_income ?? 'N/A' }}</strong></td>
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
                        <td class="info-val"><strong style="letter-spacing: 0.8px;">{{ $candidate->aadhar_number ?? 'N/A' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="info-label">Selfie Verification:</td>
                        <td class="info-val">
                            @if($candidate->selfie_verified)
                                <span style="color: #16a34a; font-weight: 700;">✓ Selfie Uploaded & Verified</span>
                            @else
                                <span style="color: #dc2626;">✗ Not Verified</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Registration Type:</td>
                        <td class="info-val">
                            @if($branch)
                                <strong style="color: #15803d;">Branch Referral: {{ $branch->name }} ({{ $branch->code }})</strong>
                            @else
                                <span style="color: #64748b;">Direct Website Registration</span>
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

            <!-- Email Footer -->
            <div class="footer">
                <p style="margin: 0 0 6px 0;">This is an automated administrative notification from <strong>Rani Matrimonial</strong>.</p>
                <p style="margin: 0;">© {{ date('Y') }} Rani Matrimonial. All rights reserved.</p>
            </div>

        </div>
    </div>
</body>
</html>
