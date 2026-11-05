@php
    $bgPath = public_path('img/invoice-bg-a4.png');
    $invYear = $transaction->created_at ? $transaction->created_at->format('Y') : date('Y');
    $invDate = $transaction->created_at ? $transaction->created_at->format('d M Y') : date('d M Y');
    $invNo = 'RANI-INV-' . $invYear . '-' . str_pad($transaction->id, 4, '0', STR_PAD_LEFT);
    $customerCode = $candidate->candidate_code ?? ('RM' . str_pad($candidate->id, 5, '0', STR_PAD_LEFT));
    $customerName = trim(($candidate->first_name ?? '') . ' ' . ($candidate->last_name ?? ''));
    if (empty($customerName)) {
        $customerName = 'Valued Member';
    }
    $paymentMethod = $transaction->payment_method ?? 'Online Payment';
    $amountRaw = (float) $transaction->amount;
    $amountFormatted = number_format($amountRaw, 2);
    $itemDesc = $transaction->title ?: ($transaction->type === 'credit' ? 'Wallet Recharge (Topup)' : 'Service Charge');
    $customerPhone = $candidate->mobile ?? $candidate->phone ?? 'N/A';
    
    $paymentId = null;
    if (!empty($transaction->payment_id)) {
        $paymentId = $transaction->payment_id;
    } elseif (!empty($transaction->description) && preg_match('/(?:Payment ID|pay_|Order ID)[:\s]+([a-zA-Z0-9_-]+)/i', $transaction->description, $pm)) {
        $paymentId = $pm[1];
    }
    if (empty($paymentId)) {
        $paymentId = $transaction->transaction_id ? ('#' . $transaction->transaction_id) : ('TXN-' . str_pad($transaction->id, 6, '0', STR_PAD_LEFT));
    }

    // Convert amount to words
    $amountInWords = 'Rupees ' . $amountFormatted . ' Only';
    if (class_exists('NumberFormatter')) {
        try {
            $nf = new NumberFormatter('en_IN', NumberFormatter::SPELLOUT);
            $amountInWords = ucwords($nf->format(floor($amountRaw))) . ' Rupees Only';
        } catch (\Throwable $e) {}
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Tax Invoice - {{ $invNo }} | Rani Matrimonial</title>
    <style>
        @page {
            margin: 0px;
            size: a4 portrait;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'DejaVu Sans', sans-serif;
        }
        body {
            margin: 0px;
            padding: 0px;
            width: 100%;
            height: 100%;
            background-color: #FAF7F2;
            color: #1A1A1A;
            font-size: 9pt;
            line-height: 1.35;
            position: relative;
        }

        /* Full Page A4 Background */
        .invoice-bg-img {
            position: fixed;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            z-index: -1000;
        }

        .rupee {
            font-family: 'DejaVu Sans', sans-serif;
            font-weight: normal;
        }

        /* Printable Content Container */
        .content-container {
            position: relative;
            z-index: 10;
            padding: 136pt 32pt 0pt 32pt;
        }

        /* Header Split Table (Left: Sumatra Sales Details, Right: Reserved for Pre-Printed TAX INVOICE Badge) */
        .header-split-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12pt;
        }
        .company-col {
            width: 62%;
            vertical-align: top;
            padding-right: 14pt;
        }
        .badge-placeholder-col {
            width: 38%;
            vertical-align: top;
            /* Pre-printed TAX INVOICE badge sits on the background image in this exact location */
        }

        .brand-sub {
            font-size: 7.5pt;
            color: #777777;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-weight: bold;
            margin-bottom: 2pt;
        }
        .company-name {
            font-size: 13pt;
            font-weight: bold;
            color: #5B0000;
            letter-spacing: 0.3px;
            margin-bottom: 3pt;
        }
        .company-meta-line {
            font-size: 8pt;
            color: #333333;
            line-height: 1.35;
            margin-bottom: 1.5pt;
        }
        .company-meta-line strong {
            color: #1A1A1A;
        }

        /* Customer & Payment Info Card */
        .cust-card {
            background-color: #FFFFFF;
            border: 1.5px solid #D4AF37;
            border-radius: 7pt;
            padding: 8pt 12pt;
            margin-bottom: 12pt;
        }
        .cust-card-header {
            font-size: 8.5pt;
            font-weight: bold;
            color: #5B0000;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1px solid #EADBBE;
            padding-bottom: 3pt;
            margin-bottom: 5pt;
        }
        .cust-split-table {
            width: 100%;
            border-collapse: collapse;
        }
        .cust-left-col {
            width: 50%;
            vertical-align: top;
            padding-right: 10pt;
        }
        .cust-right-col {
            width: 50%;
            vertical-align: top;
            padding-left: 10pt;
            border-left: 1px dashed #D4AF37;
        }
        .info-row-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-label {
            width: 95pt;
            font-size: 8pt;
            color: #555555;
            padding: 2.2pt 0;
            font-weight: 600;
        }
        .info-sep {
            width: 10pt;
            font-size: 8pt;
            color: #777777;
            padding: 2.2pt 0;
            text-align: center;
        }
        .info-val {
            font-size: 8.5pt;
            color: #111111;
            padding: 2.2pt 0;
            font-weight: bold;
        }

        .paid-badge {
            background-color: #198754;
            color: #FFFFFF;
            font-size: 7.5pt;
            font-weight: bold;
            padding: 1.5pt 7pt;
            border-radius: 3pt;
            display: inline-block;
            letter-spacing: 0.5px;
        }

        /* Items / Billing Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #FFFFFF;
            border: 1px solid #D8C7B0;
            border-radius: 6pt;
            overflow: hidden;
            margin-bottom: 10pt;
        }
        .items-table th {
            background-color: #5B0000;
            color: #FFFFFF;
            font-size: 8pt;
            font-weight: bold;
            padding: 5.5pt 8pt;
            border: 1px solid #5B0000;
            letter-spacing: 0.5px;
        }
        .items-table td {
            padding: 7pt 8pt;
            font-size: 8.5pt;
            color: #1A1A1A;
            border: 1px solid #EFE8DE;
            background-color: #FFFFFF;
            vertical-align: middle;
        }

        /* Calculation & Seal Block */
        .bottom-split-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10pt;
        }
        .seal-col {
            width: 48%;
            vertical-align: top;
            padding-right: 12pt;
        }
        .calc-col {
            width: 52%;
            vertical-align: top;
        }

        .words-card {
            background-color: #FFFFFF;
            border: 1px solid #E5D7C2;
            border-radius: 6pt;
            padding: 6pt 9pt;
            margin-bottom: 6pt;
        }
        .words-label {
            font-size: 7.5pt;
            font-weight: bold;
            color: #5B0000;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .words-val {
            font-size: 8pt;
            font-weight: bold;
            color: #111111;
            margin-top: 1.5pt;
            font-style: italic;
        }

        .system-seal-box {
            background-color: #FFFFFF;
            border: 1px dashed #D4AF37;
            border-radius: 6pt;
            padding: 6pt 8pt;
            text-align: center;
        }
        .seal-head {
            font-size: 7.5pt;
            font-weight: bold;
            color: #5B0000;
            letter-spacing: 0.5px;
        }
        .seal-note {
            font-size: 6.5pt;
            color: #666666;
            margin-top: 1.5pt;
            line-height: 1.25;
        }

        .calc-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #FFFFFF;
            border: 1px solid #E5D7C2;
            border-radius: 6pt;
            overflow: hidden;
        }
        .calc-table td {
            padding: 4pt 8pt;
            font-size: 8pt;
        }
        .calc-lbl {
            color: #555555;
            width: 50%;
        }
        .calc-val {
            text-align: right;
            font-weight: bold;
            color: #111111;
            width: 50%;
        }

        .grand-total-row td {
            background-color: #5B0000 !important;
            color: #FFFFFF !important;
            border-top: 1.5px solid #D4AF37;
            padding: 5.5pt 8pt !important;
        }
        .grand-total-row .calc-lbl {
            font-size: 9pt !important;
            font-weight: bold !important;
            color: #FFFFFF !important;
        }
        .grand-total-row .calc-val {
            font-size: 10.5pt !important;
            font-weight: bold !important;
            color: #F5D061 !important;
        }
    </style>
</head>
<body>

    <!-- 1. Full Page A4 Royal Background Image (Includes Header, Pre-Printed TAX INVOICE Badge, Thank You Pill & Footer) -->
    @if(file_exists($bgPath))
        <img src="{{ $bgPath }}" class="invoice-bg-img" alt="Rani Matrimonial Invoice" />
    @endif

    <div class="content-container">

        <!-- 2. Header Split: Sumatra Sales Details on Left (Opposite Pre-Printed TAX INVOICE Badge on Right) -->
        <table class="header-split-table">
            <tr>
                <td class="company-col">
                    <div class="brand-sub">A Brand Owned &amp; Operated By</div>
                    <div class="company-name">SUMATRA SALES PRIVATE LIMITED</div>
                    <div class="company-meta-line">17, Ranihati - Amta Road, Ranihati, Howrah, West Bengal - 711322</div>
                    <div class="company-meta-line">
                        <strong>CIN:</strong> U51909WB2020PTC237800 &nbsp;|&nbsp; <strong>GSTIN:</strong> 19ABDCS8853N1ZG
                    </div>
                    <div class="company-meta-line">
                        <strong>Phone:</strong> +91 6292237202 &nbsp;|&nbsp; <strong>Email:</strong> sumatra.sales2424@gmail.com
                    </div>
                    <div class="company-meta-line" style="color: #8A6D3B; margin-top: 2pt;">
                        <strong>Portal:</strong> www.ranimatrimonial.com
                    </div>
                </td>
                <td class="badge-placeholder-col">
                    <!-- Right area left empty so the pre-printed TAX INVOICE badge on the background image shines through untouched -->
                </td>
            </tr>
        </table>

        <!-- 3. Customer & Payment Details Card (Niche payment je korbe tar details) -->
        <div class="cust-card">
            <div class="cust-card-header">
                Customer &amp; Payment Summary
            </div>
            <table class="cust-split-table">
                <tr>
                    <!-- Left: Customer Details -->
                    <td class="cust-left-col">
                        <table class="info-row-table">
                            <tr>
                                <td class="info-label">Billed To / Name</td>
                                <td class="info-sep">:</td>
                                <td class="info-val">{{ $customerName }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Customer ID</td>
                                <td class="info-sep">:</td>
                                <td class="info-val" style="color: #5B0000;">{{ $customerCode }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Registered Mobile</td>
                                <td class="info-sep">:</td>
                                <td class="info-val">{{ $customerPhone }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Email Address</td>
                                <td class="info-sep">:</td>
                                <td class="info-val" style="font-size: 8pt;">{{ $candidate->email ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </td>

                    <!-- Right: Invoice & Payment Metadata -->
                    <td class="cust-right-col">
                        <table class="info-row-table">
                            <tr>
                                <td class="info-label">Invoice No.</td>
                                <td class="info-sep">:</td>
                                <td class="info-val" style="color: #5B0000;">{{ $invNo }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Invoice Date</td>
                                <td class="info-sep">:</td>
                                <td class="info-val">{{ $invDate }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Payment Mode</td>
                                <td class="info-sep">:</td>
                                <td class="info-val">{{ $paymentMethod }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Payment ID</td>
                                <td class="info-sep">:</td>
                                <td class="info-val" style="font-size: 7.5pt; font-family: monospace;">{{ $paymentId }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Payment Status</td>
                                <td class="info-sep">:</td>
                                <td class="info-val">
                                    <span class="paid-badge">✓ PAID</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <!-- 4. Items / Particulars Table (Table ar calculation puro) -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 7%; text-align: center;">Sl.</th>
                    <th style="width: 53%; text-align: left;">Description of Service</th>
                    <th style="width: 14%; text-align: center;">SAC Code</th>
                    <th style="width: 8%; text-align: center;">Qty</th>
                    <th style="width: 18%; text-align: right;">Amount (<span class="rupee">&#8377;</span>)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center; font-weight: bold; color: #5B0000;">1</td>
                    <td style="text-align: left;">
                        <strong>{{ $itemDesc }}</strong>
                        @if($transaction->transaction_id)
                            <div style="font-size: 7.5pt; color: #777777; margin-top: 2pt;">Transaction Ref: #{{ $transaction->transaction_id }}</div>
                        @endif
                    </td>
                    <td style="text-align: center; color: #555555;">998311</td>
                    <td style="text-align: center;">1</td>
                    <td style="text-align: right; font-weight: bold; color: #111111;">
                        <span class="rupee">&#8377;</span> {{ $amountFormatted }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- 5. Calculation Summary & Signatory Block -->
        <table class="bottom-split-table">
            <tr>
                <!-- Left: Amount in Words & Computer Generated Notice -->
                <td class="seal-col">
                    <div class="words-card">
                        <div class="words-label">Amount in Words:</div>
                        <div class="words-val">
                            {{ $amountInWords }}
                        </div>
                    </div>
                    
                    <div class="system-seal-box">
                        <div class="seal-head">SUMATRA SALES PRIVATE LIMITED</div>
                        <div class="seal-note">Authorized Computer-Generated Tax Invoice</div>
                        <div class="seal-note" style="color: #888888; font-size: 6pt; margin-top: 2pt;">
                            This is an electronically verified invoice. No physical signature is required under Information Technology Act, 2000.
                        </div>
                    </div>
                </td>

                <!-- Right: Calculations Table -->
                <td class="calc-col">
                    <table class="calc-table">
                        <tr>
                            <td class="calc-lbl">Subtotal (Taxable):</td>
                            <td class="calc-val"><span class="rupee">&#8377;</span> {{ $amountFormatted }}</td>
                        </tr>
                        <tr>
                            <td class="calc-lbl">GST (18% Inclusive):</td>
                            <td class="calc-val" style="color: #666666;">Included</td>
                        </tr>
                        <tr>
                            <td class="calc-lbl">Discount:</td>
                            <td class="calc-val" style="color: #198754;">- <span class="rupee">&#8377;</span> 0.00</td>
                        </tr>
                        <tr class="grand-total-row">
                            <td class="calc-lbl">Grand Total:</td>
                            <td class="calc-val"><span class="rupee">&#8377;</span> {{ $amountFormatted }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>
