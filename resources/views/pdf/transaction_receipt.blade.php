@php
    $logoPath = public_path('logo.png');
    $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : null;
    $invYear = $transaction->created_at ? $transaction->created_at->format('Y') : date('Y');
    $invDate = $transaction->created_at ? $transaction->created_at->format('d M Y') : date('d M Y');
    $invNo = 'RANI-INV-' . $invYear . '-' . str_pad($transaction->id, 4, '0', STR_PAD_LEFT);
    $customerCode = $candidate->candidate_code ?? ('RM' . str_pad($candidate->id, 5, '0', STR_PAD_LEFT));
    $customerName = trim(($candidate->first_name ?? '') . ' ' . ($candidate->last_name ?? ''));
    if (empty($customerName)) {
        $customerName = 'Valued Member';
    }
    $paymentMethod = $transaction->payment_method ?? 'Online Payment';
    $amountFormatted = number_format((float) $transaction->amount, 2);
    $itemDesc = $transaction->title ?: ($transaction->type === 'credit' ? 'Wallet Recharge (Topup)' : 'Service Charge');
    $customerPhone = $candidate->mobile ?? $candidate->phone ?? 'N/A';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Tax Invoice - {{ $invNo }} | Rani Matrimonial</title>
    <style>
        @page {
            margin: 0;
            size: a4 portrait;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'DejaVu Sans', sans-serif;
        }
        body {
            background-color: #FAF7F2;
            color: #1A1A1A;
            font-size: 11px;
            line-height: 1.4;
            padding: 0;
            position: relative;
        }

        .rupee {
            font-family: 'DejaVu Sans', sans-serif;
            font-weight: normal;
        }

        /* 1. Header Banner */
        .top-banner {
            width: 100%;
            background: #650000;
            color: #FFFFFF;
            padding: 18px 24px 16px 24px;
            text-align: center;
            border-bottom: 3px solid #D4AF37;
        }
        .brand-crest {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            border: 2px solid #D4AF37;
            display: block;
            margin: 0 auto 5px auto;
            background-color: #FAF7F2;
        }
        .brand-title {
            font-size: 26px;
            font-weight: bold;
            color: #FFFFFF;
            letter-spacing: 0.5px;
            line-height: 1.1;
        }
        .brand-tagline {
            font-size: 11px;
            color: #E5B842;
            letter-spacing: 1px;
            margin-top: 4px;
        }

        /* Container */
        .content-wrap {
            padding: 16px 26px 14px 26px;
        }

        /* 2. Company Info & Tax Invoice Badge */
        .company-invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .company-col {
            width: 62%;
            vertical-align: middle;
            padding-right: 14px;
        }
        .divider-col {
            width: 2%;
            vertical-align: middle;
            text-align: center;
        }
        .divider-line {
            height: 95px;
            width: 1.5px;
            background-color: #D4AF37;
            margin: 0 auto;
        }
        .badge-col {
            width: 36%;
            vertical-align: middle;
            text-align: center;
            padding-left: 10px;
        }

        .company-subtitle {
            font-size: 10px;
            color: #666666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .company-name {
            font-size: 15px;
            font-weight: bold;
            color: #1A1A1A;
            margin-bottom: 5px;
        }
        .meta-line {
            font-size: 9.5px;
            color: #333333;
            margin-bottom: 3px;
            line-height: 1.35;
        }
        .meta-line strong {
            color: #1A1A1A;
        }

        /* Tax Invoice Badge */
        .tax-invoice-shield {
            background-color: #650000;
            border: 2px solid #D4AF37;
            border-radius: 12px;
            padding: 12px 20px;
            display: inline-block;
            text-align: center;
        }
        .tax-invoice-shield .tax-text {
            font-size: 14px;
            font-weight: bold;
            color: #E5B842;
            letter-spacing: 3px;
            line-height: 1;
        }
        .tax-invoice-shield .inv-text {
            font-size: 18px;
            font-weight: bold;
            color: #FFFFFF;
            letter-spacing: 2px;
            line-height: 1.2;
            margin-top: 3px;
        }

        /* 3. Customer Info & Invoice Metadata Card */
        .cust-meta-card {
            background-color: #FFFFFF;
            border: 1.2px solid #E5D7C2;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 14px;
        }
        .cust-meta-table {
            width: 100%;
            border-collapse: collapse;
        }
        .cust-meta-table td {
            padding: 4.5px 6px;
            font-size: 10.5px;
            vertical-align: middle;
        }
        .col-half {
            width: 50%;
        }
        .card-label {
            color: #555555;
            font-weight: 600;
            width: 120px;
            display: inline-block;
        }
        .card-val {
            color: #111111;
            font-weight: bold;
        }
        .paid-pill {
            background-color: #198754;
            color: #FFFFFF;
            font-size: 9px;
            font-weight: bold;
            padding: 2.5px 10px;
            border-radius: 10px;
            display: inline-block;
            letter-spacing: 0.5px;
        }

        /* 4. Billing Details Ribbon */
        .ribbon-wrap {
            text-align: center;
            margin: 10px 0 12px 0;
        }
        .ribbon-table {
            width: 100%;
            border-collapse: collapse;
        }
        .ribbon-table td {
            vertical-align: middle;
        }
        .ribbon-line {
            height: 1.5px;
            background-color: #D4AF37;
            width: 100%;
        }
        .ribbon-badge {
            background: #650000;
            color: #FFFFFF;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 5px 22px;
            border-radius: 14px;
            border: 1.5px solid #D4AF37;
            display: inline-block;
            white-space: nowrap;
        }

        /* 5. Billing Table */
        .bill-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #FFFFFF;
            border: 1px solid #D8C7B0;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 12px;
        }
        .bill-table th {
            background-color: #650000;
            color: #FFFFFF;
            font-size: 10px;
            font-weight: bold;
            padding: 8px 12px;
            border: 1px solid #650000;
            letter-spacing: 0.5px;
        }
        .bill-table td {
            padding: 10px 12px;
            font-size: 10.5px;
            color: #1A1A1A;
            border: 1px solid #EFE8DE;
            background-color: #FFFFFF;
        }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }

        /* Calculation Section */
        .summary-wrap {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .summary-wrap td {
            vertical-align: middle;
        }
        .seal-art {
            width: 48%;
            text-align: center;
            padding-right: 14px;
        }
        .seal-art-box {
            display: inline-block;
            background-color: #FFFFFF;
            border: 1px solid #D4AF37;
            border-radius: 10px;
            padding: 12px 18px;
            text-align: center;
        }
        .seal-title {
            font-size: 11px;
            font-weight: bold;
            color: #650000;
            letter-spacing: 0.5px;
        }
        .seal-subtext {
            font-size: 8.5px;
            color: #777777;
            margin-top: 4px;
            line-height: 1.3;
        }

        .calc-col {
            width: 52%;
        }
        .calc-table {
            width: 100%;
            border-collapse: collapse;
        }
        .calc-table td {
            padding: 4px 6px;
            font-size: 11px;
        }
        .calc-lbl {
            font-weight: bold;
            color: #333333;
            width: 42%;
        }
        .calc-sep {
            width: 6%;
            text-align: center;
            font-weight: bold;
        }
        .calc-val {
            text-align: right;
            font-weight: bold;
            color: #1A1A1A;
            width: 52%;
        }
        .grand-total-box {
            background-color: #650000;
            border: 1.5px solid #D4AF37;
            border-radius: 8px;
            padding: 8px 12px;
            margin-top: 5px;
        }
        .grand-total-box td {
            color: #FFFFFF !important;
            font-size: 13px !important;
            font-weight: bold !important;
            padding: 0;
        }
        .grand-total-box .calc-val {
            color: #E5B842 !important;
            font-size: 14px !important;
        }

        /* 6. Thank you callout */
        .thank-you-pill {
            text-align: center;
            margin: 6px auto 14px auto;
            width: 78%;
            background-color: #FFFFFF;
            border: 1.5px solid #D4AF37;
            border-radius: 18px;
            padding: 7px 18px;
            font-size: 11.5px;
            font-weight: bold;
            color: #650000;
            letter-spacing: 0.4px;
        }

        /* 7. Footer Banner */
        .bottom-banner {
            width: 100%;
            background: #650000;
            color: #FFFFFF;
            padding: 14px 24px;
            border-top: 2.5px solid #D4AF37;
            position: absolute;
            bottom: 0;
            left: 0;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-brand-col {
            width: 22%;
            vertical-align: middle;
            text-align: center;
            border-right: 1px solid rgba(212, 175, 55, 0.4);
            padding-right: 12px;
        }
        .footer-brand-title {
            font-size: 12px;
            color: #FFFFFF;
            font-weight: bold;
        }
        .footer-brand-tagline {
            font-size: 8px;
            color: #E5B842;
            margin-top: 2px;
        }
        .footer-badges-col {
            width: 78%;
            vertical-align: middle;
            padding-left: 14px;
        }
        .badges-table {
            width: 100%;
            border-collapse: collapse;
        }
        .badge-cell {
            text-align: center;
            width: 20%;
            vertical-align: top;
            padding: 0 4px;
        }
        .badge-label {
            font-size: 8px;
            color: #FFFFFF;
            font-weight: 600;
            line-height: 1.25;
        }
    </style>
</head>
<body>

    <!-- 1. Top Royal Burgundy Banner -->
    <div class="top-banner">
        @if($logoBase64)
            <img src="{{ $logoBase64 }}" alt="Rani Logo" class="brand-crest">
        @endif
        <div class="brand-title">Rani Matrimonial</div>
        <div class="brand-tagline">- Find Your Forever Partner -</div>
    </div>

    <div class="content-wrap">

        <!-- 2. Corporate Details & Tax Invoice Badge -->
        <table class="company-invoice-table">
            <tr>
                <td class="company-col">
                    <div class="company-subtitle">A Brand of</div>
                    <div class="company-name">Sumatra Sales Private Limited</div>
                    <div class="meta-line">17, Ranihati - Amta Road, Ranihati, Howrah, West Bengal - 711322</div>
                    <div class="meta-line"><strong>CIN:</strong> U51909WB2020PTC237800</div>
                    <div class="meta-line"><strong>GSTIN:</strong> 19ABDCS8853N1ZG</div>
                    <div class="meta-line"><strong>Phone:</strong> +91 6292237202</div>
                    <div class="meta-line"><strong>Email:</strong> sumatra.sales2424@gmail.com</div>
                </td>
                <td class="divider-col">
                    <div class="divider-line"></div>
                </td>
                <td class="badge-col">
                    <div class="tax-invoice-shield">
                        <div class="tax-text">TAX</div>
                        <div class="inv-text">INVOICE</div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- 3. Customer Info & Invoice Metadata Card -->
        <div class="cust-meta-card">
            <table class="cust-meta-table">
                <tr>
                    <td class="col-half">
                        <span class="card-label">Customer Name :</span>
                        <span class="card-val">{{ $customerName }}</span>
                    </td>
                    <td class="col-half">
                        <span class="card-label">Invoice No. :</span>
                        <span class="card-val">{{ $invNo }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="col-half">
                        <span class="card-label">Customer ID :</span>
                        <span class="card-val">{{ $customerCode }}</span>
                    </td>
                    <td class="col-half">
                        <span class="card-label">Invoice Date :</span>
                        <span class="card-val">{{ $invDate }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="col-half">
                        <span class="card-label">Email :</span>
                        <span class="card-val">{{ $candidate->email ?? 'N/A' }}</span>
                    </td>
                    <td class="col-half">
                        <span class="card-label">Payment Method :</span>
                        <span class="card-val">{{ $paymentMethod }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="col-half">
                        <span class="card-label">Mobile :</span>
                        <span class="card-val">{{ $customerPhone }}</span>
                    </td>
                    <td class="col-half">
                        <span class="card-label">Payment Status :</span>
                        <span class="paid-pill">PAID</span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- 4. Billing Details Ribbon Banner -->
        <div class="ribbon-wrap">
            <table class="ribbon-table">
                <tr>
                    <td style="width: 32%;"><div class="ribbon-line"></div></td>
                    <td style="width: 36%; text-align: center;">
                        <span class="ribbon-badge">BILLING DETAILS</span>
                    </td>
                    <td style="width: 32%;"><div class="ribbon-line"></div></td>
                </tr>
            </table>
        </div>

        <!-- 5. Items & Pricing Table -->
        <table class="bill-table">
            <thead>
                <tr>
                    <th style="width: 12%;" class="text-center">Sl. No.</th>
                    <th style="width: 56%;" class="text-left">Description</th>
                    <th style="width: 14%;" class="text-center">Qty</th>
                    <th style="width: 18%;" class="text-right">Amount (<span class="rupee">&#8377;</span>)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center" style="font-weight: bold; color: #650000;">1</td>
                    <td class="text-left">
                        <strong style="color: #1A1A1A;">{{ $itemDesc }}</strong>
                        @if($transaction->transaction_id)
                            <div style="font-size: 8.5px; color: #666666; margin-top: 2px;">TXN REF: #{{ $transaction->transaction_id }}</div>
                        @endif
                    </td>
                    <td class="text-center">1</td>
                    <td class="text-right" style="font-weight: bold;"><span class="rupee">&#8377;</span> {{ $amountFormatted }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Summary & Calculation -->
        <table class="summary-wrap">
            <tr>
                <td class="seal-art">
                    <div class="seal-art-box">
                        <div class="seal-title">Rani Matrimonial</div>
                        <div class="seal-subtext">Official Computer Generated Tax Invoice</div>
                        <div class="seal-subtext" style="color: #650000; font-weight: bold; margin-top: 3px;">Sumatra Sales Private Limited</div>
                    </div>
                </td>
                <td class="calc-col">
                    <table class="calc-table">
                        <tr>
                            <td class="calc-lbl">Subtotal</td>
                            <td class="calc-sep">:</td>
                            <td class="calc-val"><span class="rupee">&#8377;</span> {{ $amountFormatted }}</td>
                        </tr>
                        <tr>
                            <td class="calc-lbl">Discount</td>
                            <td class="calc-sep">:</td>
                            <td class="calc-val"><span class="rupee">&#8377;</span> 0.00</td>
                        </tr>
                    </table>
                    <div class="grand-total-box">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 42%;">Grand Total</td>
                                <td style="width: 6%; text-align: center;">:</td>
                                <td class="calc-val" style="width: 52%; text-align: right;"><span class="rupee">&#8377;</span> {{ $amountFormatted }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        <!-- 6. Thank You Callout -->
        <div class="thank-you-pill">
            Thank you for choosing Rani Matrimonial!
        </div>

    </div>

    <!-- 7. Bottom Royal Burgundy Footer Banner -->
    <div class="bottom-banner">
        <table class="footer-table">
            <tr>
                <td class="footer-brand-col">
                    <div class="footer-brand-title">Rani Matrimonial</div>
                    <div class="footer-brand-tagline">Find Your Forever Partner</div>
                </td>
                <td class="footer-badges-col">
                    <table class="badges-table">
                        <tr>
                            <td class="badge-cell">
                                <span class="badge-label">Verified<br>Profiles</span>
                            </td>
                            <td class="badge-cell">
                                <span class="badge-label">Safe &amp; Secure<br>Communication</span>
                            </td>
                            <td class="badge-cell">
                                <span class="badge-label">Smart<br>Matching</span>
                            </td>
                            <td class="badge-cell">
                                <span class="badge-label">Family<br>Friendly</span>
                            </td>
                            <td class="badge-cell">
                                <span class="badge-label">Dedicated<br>Support</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
