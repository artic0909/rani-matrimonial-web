@php
    $logoPath = public_path('logo.png');
    $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : null;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $transaction->transaction_id ?? $transaction->id }} - Rani Matrimonial Admin</title>

    <!-- Bootstrap 5 & Icons -->
    <link rel="stylesheet" href="{{ asset('admin/libs/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/libs/bootstrap-icons/bootstrap-icons.css') }}">

    <style>
        :root {
            --brand-forest-dark: #072F1F;
            --brand-forest-medium: #0F4A32;
            --brand-lime: #C8E974;
        }
        body {
            background-color: #EEF2F0;
            color: #2D3748;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Top Action Bar for Admin */
        .receipt-action-bar {
            background: #FFFFFF;
            border-bottom: 1px solid rgba(11, 19, 15, 0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 12px 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        /* Paper Container */
        .receipt-page-container {
            max-width: 820px;
            margin: 28px auto 48px auto;
            background: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 24px;
        }

        /* Royal Double Outer Border Frame */
        .outer-frame {
            border: 2.5px solid #750000;
            border-radius: 6px;
            padding: 5px;
            background-color: #ffffff;
        }
        .inner-frame {
            border: 1px solid #d4af37;
            border-radius: 4px;
            padding: 24px 24px;
            background-color: #ffffff;
        }

        /* Header */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #750000;
            padding-bottom: 14px;
            margin-bottom: 16px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .brand-logo {
            width: 52px;
            height: 52px;
            border-radius: 6px;
            border: 1.5px solid #d4af37;
            object-fit: cover;
        }
        .brand-title {
            font-size: 22px;
            font-weight: 800;
            color: #750000;
            letter-spacing: 0.5px;
            line-height: 1.1;
        }
        .brand-subtitle {
            font-size: 10px;
            color: #977418;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 2px;
        }
        .brand-subtext {
            font-size: 9px;
            color: #718096;
            margin-top: 2px;
        }
        .doc-title {
            font-size: 18px;
            color: #1a202c;
            text-transform: uppercase;
            font-weight: 800;
            text-align: right;
            margin-bottom: 4px;
        }
        .doc-meta-table {
            width: 100%;
            margin-top: 4px;
        }
        .doc-meta-table td {
            font-size: 10px;
            padding: 2px 0;
            text-align: right;
            color: #4a5568;
        }
        .doc-meta-table td.meta-val {
            font-weight: 700;
            color: #1a202c;
            padding-left: 6px;
        }

        /* 2-Column Info Cards */
        .info-table {
            width: 100%;
            margin-bottom: 16px;
            border-collapse: separate;
            border-spacing: 8px 0;
        }
        .info-table td {
            width: 50%;
            vertical-align: top;
            padding: 0;
        }
        .info-card {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
            background-color: #fafbfc;
        }
        .info-card-header {
            background-color: #750000;
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 6px 12px;
        }
        .card-row-table {
            width: 100%;
            padding: 8px 12px;
        }
        .card-row-table td {
            font-size: 10px;
            padding: 3px 0;
        }
        .card-row-table td.label-cell {
            color: #718096;
            width: 42%;
            font-weight: 500;
        }
        .card-row-table td.val-cell {
            color: #1a202c;
            font-weight: 700;
        }

        /* Table */
        .txn-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            overflow: hidden;
        }
        .txn-table th {
            background-color: #750000;
            color: #ffffff;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 12px;
            text-align: left;
        }
        .txn-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10.5px;
            vertical-align: middle;
            background-color: #ffffff;
        }
        .txn-title {
            font-weight: 700;
            color: #1a202c;
            font-size: 11px;
        }
        .txn-desc {
            font-size: 9.5px;
            color: #718096;
            margin-top: 2px;
        }
        .badge-success {
            background-color: #def7ec;
            color: #03543f;
            border: 1px solid #84e1bc;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 9.5px;
            font-weight: 700;
            display: inline-block;
        }
        .amount-credit {
            font-size: 13px;
            font-weight: 800;
            color: #046c4e;
            font-family: monospace;
        }
        .amount-debit {
            font-size: 13px;
            font-weight: 800;
            color: #c81e1e;
            font-family: monospace;
        }

        /* Summary */
        .summary-table {
            width: 100%;
            margin-bottom: 16px;
        }
        .summary-table td {
            vertical-align: top;
        }
        .seal-box {
            border: 1.5px dashed #046c4e;
            background-color: #f3faf7;
            border-radius: 6px;
            padding: 8px 12px;
            color: #046c4e;
            font-size: 10px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .disclaimer-text {
            font-size: 9px;
            color: #718096;
            line-height: 1.45;
        }
        .calc-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
        }
        .calc-table td {
            padding: 6px 10px;
            font-size: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .calc-table td.calc-label {
            color: #4a5568;
            font-weight: 500;
        }
        .calc-table td.calc-val {
            text-align: right;
            font-weight: 700;
            color: #1a202c;
            font-family: monospace;
            font-size: 11px;
        }
        .calc-table tr.total-row td {
            border-top: 2px solid #750000;
            border-bottom: none;
            background-color: #fdf2f2;
            padding: 8px 10px;
            font-size: 12px;
            font-weight: 800;
            color: #750000;
        }

        /* Footer */
        .receipt-footer {
            border-top: 1.5px solid #750000;
            padding-top: 10px;
            font-size: 9px;
            color: #718096;
            text-align: center;
            line-height: 1.45;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: #FFFFFF !important;
                padding: 0 !important;
            }
            .receipt-action-bar {
                display: none !important;
            }
            .receipt-page-container {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
            @page {
                size: A4 portrait;
                margin: 10mm;
            }
        }
    </style>
</head>
<body>

    <!-- Top Action Bar -->
    <div class="receipt-action-bar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <button type="button" onclick="window.history.back()" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Back
            </button>
            <span class="text-muted small">|</span>
            <span class="fw-bold text-dark font-monospace small">Receipt #{{ $transaction->transaction_id ?? $transaction->id }}</span>
            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5">
                {{ ucfirst($transaction->status ?? 'Completed') }}
            </span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Print / Save as PDF Button -->
            <button type="button" 
                    onclick="window.print()" 
                    class="btn btn-dark btn-sm rounded-pill px-3.5 fw-bold shadow-sm d-inline-flex align-items-center gap-1.5"
                    style="background-color: var(--brand-forest-dark); border-color: var(--brand-forest-dark);">
                <i class="bi bi-printer-fill"></i>
                <span>Print / Save as PDF</span>
            </button>

            <!-- Direct Download PDF Button -->
            <a href="{{ route('admin.transactions.receipt', ['id' => $transaction->id, 'download' => 1]) }}" 
               class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-semibold">
                <i class="bi bi-download me-1"></i> Download PDF
            </a>
        </div>
    </div>

    <!-- Receipt Paper Container -->
    <div class="receipt-page-container">
        <div class="outer-frame">
            <div class="inner-frame">

                <!-- Header -->
                <table class="header-table">
                    <tr>
                        @if($logoBase64)
                            <td style="width: 58px;">
                                <img src="{{ $logoBase64 }}" alt="Rani Logo" class="brand-logo">
                            </td>
                        @endif
                        <td style="padding-left: {{ $logoBase64 ? '10px' : '0' }};">
                            <div class="brand-title">RANI MATRIMONIAL</div>
                            <div class="brand-subtitle">SUMATRA SALES PRIVATE LIMITED</div>
                            <div class="brand-subtext">Premier Matrimony & Digital Matchmaking Services</div>
                        </td>
                        <td style="width: 260px;">
                            <div class="doc-title">Payment Receipt</div>
                            <table class="doc-meta-table">
                                <tr>
                                    <td>Receipt Ref:</td>
                                    <td class="meta-val font-monospace">#{{ $transaction->transaction_id ?? $transaction->id }}</td>
                                </tr>
                                <tr>
                                    <td>Date & Time:</td>
                                    <td class="meta-val">{{ $transaction->created_at ? $transaction->created_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Candidate & Account Details -->
                <table class="info-table">
                    <tr>
                        <td>
                            <div class="info-card">
                                <div class="info-card-header">Billed To (Candidate Details)</div>
                                <table class="card-row-table">
                                    <tr>
                                        <td class="label-cell">Candidate Name:</td>
                                        <td class="val-cell">{{ $candidate->first_name ?? 'Candidate' }} {{ $candidate->last_name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label-cell">Candidate Code:</td>
                                        <td class="val-cell font-monospace">{{ $candidate->candidate_code ?? ($candidate->profile_id ?? ('RM' . str_pad($candidate->id ?? 0, 5, '0', STR_PAD_LEFT))) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label-cell">Email Address:</td>
                                        <td class="val-cell">{{ $candidate->email ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label-cell">Mobile Number:</td>
                                        <td class="val-cell font-monospace">{{ $candidate->phone ?? ($candidate->mobile ?? 'N/A') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                        <td>
                            <div class="info-card">
                                <div class="info-card-header">Wallet & Payment Details</div>
                                <table class="card-row-table">
                                    <tr>
                                        <td class="label-cell">Wallet ID:</td>
                                        <td class="val-cell font-monospace">{{ $wallet->wallet_id ?? ($wallet->formatted_card_number ?? 'WALLET-' . str_pad($candidate->id ?? 1, 5, '0', STR_PAD_LEFT)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label-cell">Payment Mode:</td>
                                        <td class="val-cell">{{ $transaction->payment_method ?? ($transaction->type === 'credit' ? 'Razorpay Gateway' : 'Wallet Balance') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label-cell">Status:</td>
                                        <td class="val-cell">
                                            <span class="badge-success">{{ strtoupper($transaction->status ?? 'completed') }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-cell">Transaction Type:</td>
                                        <td class="val-cell">
                                            <span class="{{ $transaction->type === 'credit' ? 'text-success' : 'text-danger' }} fw-bold">
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
                            <th style="width: 48%;">Description / Purpose</th>
                            <th style="width: 20%;">Category</th>
                            <th style="width: 14%;" class="text-center">Status</th>
                            <th style="width: 18%; text-align: right;">Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="txn-title">{{ $transaction->title ?? 'Transaction' }}</div>
                                @if($transaction->description)
                                    <div class="txn-desc">{{ $transaction->description }}</div>
                                @endif
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #4a5568;">{{ $transaction->category ?? ($transaction->type === 'credit' ? 'Wallet Recharge' : 'Service Deduction') }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge-success">{{ strtoupper($transaction->status ?? 'completed') }}</span>
                            </td>
                            <td style="text-align: right;">
                                <span class="{{ $transaction->type === 'credit' ? 'amount-credit' : 'amount-debit' }}">
                                    {{ $transaction->type === 'credit' ? '+' : '-' }} ₹ {{ number_format((float)$transaction->amount, 2) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Summary & Certification -->
                <table class="summary-table">
                    <tr>
                        <td style="width: 52%; padding-right: 14px;">
                            <div class="seal-box">
                                ✓ Verified & Authorized by Rani Matrimonial
                            </div>
                            <div class="disclaimer-text">
                                This is a computer-generated official receipt issued for electronic record keeping. No physical signature is required. For inquiries, quote reference ID: <strong>#{{ $transaction->transaction_id ?? $transaction->id }}</strong>.
                            </div>
                        </td>
                        <td style="width: 48%;">
                            <table class="calc-table">
                                <tr>
                                    <td class="calc-label">Transaction Amount:</td>
                                    <td class="calc-val">₹ {{ number_format((float)$transaction->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="calc-label">Wallet Balance After:</td>
                                    <td class="calc-val" style="color: #046c4e;">₹ {{ number_format((float)($transaction->balance_after ?? 0), 2) }}</td>
                                </tr>
                                <tr class="total-row">
                                    <td>Total Settled:</td>
                                    <td class="calc-val" style="color: #750000;">₹ {{ number_format((float)$transaction->amount, 2) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Footer -->
                <div class="receipt-footer">
                    <p class="mb-1"><strong>Rani Matrimonial</strong> • Premier Matrimony & Matchmaking Portal • <strong>SUMATRA SALES PRIVATE LIMITED</strong></p>
                    <p class="mb-1">Helpline: +91-6292237202 • Support: info.ranimatrimonial@gmail.com • Web: https://ranimatrimonial.com</p>
                    <p class="mb-0 text-muted" style="font-size: 8px;">Generated on {{ now()->format('d M Y, h:i A') }} • System Ref: {{ $transaction->transaction_id ?? $transaction->id }}</p>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
