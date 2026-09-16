@php
    $logoPath = public_path('logo.png');
    $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : null;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Receipt - {{ $transaction->transaction_id }} | Rani Matrimonial</title>
    <style>
        @page {
            margin: 15px 18px;
            size: a4 portrait;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'DejaVu Sans', sans-serif;
        }
        body {
            background-color: #ffffff;
            color: #2d3748;
            font-size: 10.5px;
            line-height: 1.4;
            padding: 0;
        }
        
        /* Royal Double Outer Border Frame */
        .outer-frame {
            border: 2.5px solid #750000;
            border-radius: 6px;
            padding: 4px;
            background-color: #ffffff;
        }
        .inner-frame {
            border: 1px solid #d4af37;
            border-radius: 4px;
            padding: 18px 20px;
            background-color: #ffffff;
        }

        /* Top Header */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #750000;
            padding-bottom: 12px;
            margin-bottom: 14px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .brand-logo {
            width: 50px;
            height: 50px;
            border-radius: 6px;
            border: 1.5px solid #d4af37;
        }
        .brand-title {
            font-size: 21px;
            font-weight: bold;
            color: #750000;
            letter-spacing: 0.5px;
            line-height: 1.1;
        }
        .brand-subtitle {
            font-size: 9.5px;
            color: #977418;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 2px;
        }
        .brand-subtext {
            font-size: 8.5px;
            color: #718096;
            margin-top: 2px;
        }
        .doc-title {
            font-size: 17px;
            color: #1a202c;
            text-transform: uppercase;
            font-weight: bold;
            text-align: right;
            margin-bottom: 3px;
        }
        .doc-meta-table {
            width: 100%;
            margin-top: 3px;
        }
        .doc-meta-table td {
            font-size: 9.5px;
            padding: 1.5px 0;
            text-align: right;
            color: #4a5568;
        }
        .doc-meta-table td.meta-val {
            font-weight: bold;
            color: #1a202c;
            padding-left: 5px;
        }

        /* 2-Column Info Grid */
        .info-table {
            width: 100%;
            margin-bottom: 14px;
        }
        .info-table > tbody > tr > td {
            width: 50%;
            vertical-align: top;
        }
        .info-card {
            background-color: #f8fafc;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            padding: 8px 12px;
        }
        .info-card.left {
            margin-right: 6px;
        }
        .info-card.right {
            margin-left: 6px;
        }
        .info-card-header {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            color: #750000;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #cbd5e0;
            padding-bottom: 4px;
            margin-bottom: 6px;
        }
        .card-row-table {
            width: 100%;
        }
        .card-row-table td {
            font-size: 10px;
            padding: 2px 0;
            vertical-align: middle;
        }
        .card-row-table td.label-cell {
            color: #718096;
            width: 38%;
        }
        .card-row-table td.val-cell {
            color: #1a202c;
            font-weight: 600;
            width: 62%;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 1.5px 6px;
            border-radius: 3px;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .badge-success {
            background-color: #def7ec;
            color: #03543f;
            border: 1px solid #bcf0da;
        }
        .badge-credit {
            background-color: #def7ec;
            color: #03543f;
            border: 1px solid #bcf0da;
        }
        .badge-debit {
            background-color: #fde8e8;
            color: #9b1c1c;
            border: 1px solid #fbd5d5;
        }

        /* Bordered Transaction Table */
        .txn-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #cbd5e0;
            margin-bottom: 14px;
        }
        .txn-table th {
            background-color: #750000;
            color: #ffffff;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 7px 10px;
            text-align: left;
            border: 1px solid #750000;
        }
        .txn-table th.text-right,
        .txn-table td.text-right {
            text-align: right;
        }
        .txn-table th.text-center,
        .txn-table td.text-center {
            text-align: center;
        }
        .txn-table td {
            padding: 9px 10px;
            border: 1px solid #e2e8f0;
            font-size: 10.5px;
            vertical-align: middle;
            background-color: #ffffff;
        }
        .txn-title {
            font-weight: bold;
            color: #1a202c;
            font-size: 11px;
        }
        .txn-desc {
            font-size: 9px;
            color: #718096;
            margin-top: 1.5px;
        }
        .amount-credit {
            color: #046c4e;
            font-weight: bold;
            font-size: 12px;
        }
        .amount-debit {
            color: #c81e1e;
            font-weight: bold;
            font-size: 12px;
        }

        /* Summary & Certification */
        .summary-table {
            width: 100%;
            margin-bottom: 14px;
        }
        .summary-table > tbody > tr > td {
            vertical-align: top;
        }
        .seal-box {
            border: 1.5px dashed #d4af37;
            color: #750000;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 9px;
            border-radius: 5px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            background-color: #fffdf5;
            display: inline-block;
            margin-bottom: 6px;
        }
        .disclaimer-text {
            font-size: 8.5px;
            color: #718096;
            line-height: 1.35;
            max-width: 95%;
        }

        /* Calc Box */
        .calc-table {
            width: 100%;
            border: 1px solid #cbd5e0;
            border-radius: 5px;
            background-color: #f8fafc;
            border-collapse: collapse;
        }
        .calc-table td {
            padding: 5px 10px;
            font-size: 10px;
            border-bottom: 1px solid #edf2f7;
        }
        .calc-table td.calc-label {
            color: #718096;
        }
        .calc-table td.calc-val {
            text-align: right;
            font-weight: bold;
            color: #2d3748;
        }
        .calc-table tr.total-row td {
            border-top: 2px solid #750000;
            border-bottom: none;
            background-color: #fdf2f2;
            padding: 7px 10px;
            font-size: 11.5px;
            font-weight: bold;
            color: #750000;
        }

        /* Footer */
        .footer {
            border-top: 1.5px solid #750000;
            padding-top: 10px;
            font-size: 9px;
            color: #718096;
            text-align: center;
            line-height: 1.45;
        }
        .footer strong {
            color: #4a5568;
        }
    </style>
</head>
<body>
    <div class="outer-frame">
        <div class="inner-frame">

            <!-- Header -->
            <table class="header-table">
                <tr>
                    @if($logoBase64)
                        <td style="width: 55px;">
                            <img src="{{ $logoBase64 }}" alt="Rani Logo" class="brand-logo">
                        </td>
                    @endif
                    <td style="padding-left: {{ $logoBase64 ? '8px' : '0' }};">
                        <div class="brand-title">RANI MATRIMONIAL</div>
                        <div class="brand-subtitle">SUMATRA SALES PRIVATE LIMITED</div>
                        <div class="brand-subtext">Premier Matrimony & Digital Matchmaking Services</div>
                    </td>
                    <td style="width: 240px;">
                        <div class="doc-title">Payment Receipt</div>
                        <table class="doc-meta-table">
                            <tr>
                                <td>Receipt Ref:</td>
                                <td class="meta-val">#{{ $transaction->transaction_id }}</td>
                            </tr>
                            <tr>
                                <td>Date & Time:</td>
                                <td class="meta-val">{{ $transaction->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Candidate & Account Details (2-Column Bordered Cards) -->
            <table class="info-table">
                <tr>
                    <td>
                        <div class="info-card left">
                            <div class="info-card-header">Billed To (Candidate Details)</div>
                            <table class="card-row-table">
                                <tr>
                                    <td class="label-cell">Candidate Name:</td>
                                    <td class="val-cell">{{ $candidate->first_name }} {{ $candidate->last_name }}</td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Candidate Code:</td>
                                    <td class="val-cell">{{ $candidate->candidate_code ?? ('RM' . str_pad($candidate->id, 5, '0', STR_PAD_LEFT)) }}</td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Email Address:</td>
                                    <td class="val-cell">{{ $candidate->email }}</td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Mobile Number:</td>
                                    <td class="val-cell">{{ $candidate->phone ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div class="info-card right">
                            <div class="info-card-header">Wallet & Payment Details</div>
                            <table class="card-row-table">
                                <tr>
                                    <td class="label-cell">Privilege Card:</td>
                                    <td class="val-cell font-mono">{{ $wallet->formatted_card_number }}</td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Payment Mode:</td>
                                    <td class="val-cell">{{ $transaction->payment_method ?? ($transaction->type === 'credit' ? 'Razorpay Gateway' : 'Wallet Balance') }}</td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Status:</td>
                                    <td class="val-cell">
                                        <span class="badge badge-success">{{ strtoupper($transaction->status) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Transaction Type:</td>
                                    <td class="val-cell">
                                        <span class="badge {{ $transaction->type === 'credit' ? 'badge-credit' : 'badge-debit' }}">
                                            {{ $transaction->type === 'credit' ? 'CREDIT / TOP-UP' : 'DEBIT / DEDUCTION' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Bordered Transaction Table -->
            <table class="txn-table">
                <thead>
                    <tr>
                        <th style="width: 46%;">Description / Purpose</th>
                        <th style="width: 22%;">Category</th>
                        <th style="width: 14%;" class="text-center">Status</th>
                        <th style="width: 18%;" class="text-right">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="txn-title">{{ $transaction->title }}</div>
                            @if($transaction->description)
                                <div class="txn-desc">{{ $transaction->description }}</div>
                            @endif
                        </td>
                        <td>
                            <span style="font-weight: 600; color: #4a5568;">{{ $transaction->category ?? ($transaction->type === 'credit' ? 'Wallet Recharge' : 'Service Deduction') }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-success">{{ strtoupper($transaction->status) }}</span>
                        </td>
                        <td class="text-right">
                            <span class="{{ $transaction->type === 'credit' ? 'amount-credit' : 'amount-debit' }}">
                                {{ $transaction->type === 'credit' ? '+' : '-' }} ₹ {{ number_format($transaction->amount, 2) }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Summary & Certification -->
            <table class="summary-table">
                <tr>
                    <td style="width: 52%; padding-right: 12px;">
                        <div class="seal-box">
                            ✓ Verified & Authorized by Rani Matrimonial
                        </div>
                        <div class="disclaimer-text">
                            This is a computer-generated official receipt issued for electronic record keeping. No physical signature is required. For inquiries, quote reference ID: <strong>#{{ $transaction->transaction_id }}</strong>.
                        </div>
                    </td>
                    <td style="width: 48%;">
                        <table class="calc-table">
                            <tr>
                                <td class="calc-label">Transaction Amount:</td>
                                <td class="calc-val">₹ {{ number_format($transaction->amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="calc-label">Wallet Balance After:</td>
                                <td class="calc-val" style="color: #046c4e;">₹ {{ number_format($transaction->balance_after, 2) }}</td>
                            </tr>
                            <tr class="total-row">
                                <td>Total Settled:</td>
                                <td class="calc-val" style="color: #750000;">₹ {{ number_format($transaction->amount, 2) }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Footer -->
            <div class="footer">
                <p><strong>Rani Matrimonial</strong> • Premier Matrimony & Matchmaking Portal • <strong>SUMATRA SALES PRIVATE LIMITED</strong></p>
                <p style="margin-top: 2px;">Helpline: +91-6292237202 • Support: info.ranimatrimonial@gmail.com • Web: https://ranimatrimonial.com</p>
                <p style="margin-top: 3px; font-size: 8px; color: #a0aec0;">Generated on {{ now()->format('d M Y, h:i A') }} • System Ref: {{ $transaction->transaction_id }}</p>
            </div>

        </div>
    </div>
</body>
</html>
