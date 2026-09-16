<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt - {{ $transaction->transaction_id }} | Rani Matrimonial</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        body {
            background-color: #ffffff;
            color: #2d3748;
            font-size: 12px;
            line-height: 1.4;
            padding: 30px;
        }
        .container {
            width: 100%;
            max-width: 750px;
            margin: 0 auto;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            position: relative;
        }
        .header {
            border-bottom: 2px solid #750000;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .header table {
            width: 100%;
        }
        .brand-title {
            font-size: 24px;
            font-weight: bold;
            color: #750000;
            letter-spacing: 0.5px;
        }
        .brand-subtitle {
            font-size: 11px;
            color: #d4af37;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .doc-title {
            text-align: right;
        }
        .doc-title h2 {
            font-size: 18px;
            color: #1a202c;
            text-transform: uppercase;
            font-weight: 800;
            margin-bottom: 4px;
        }
        .doc-title p {
            font-size: 11px;
            color: #718096;
            font-family: monospace;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
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
        .badge-success {
            background-color: #e1effe;
            color: #1e429f;
            border: 1px solid #c3ddfd;
        }
        .info-grid {
            width: 100%;
            margin-bottom: 24px;
        }
        .info-grid td {
            vertical-align: top;
            width: 50%;
        }
        .info-box {
            background-color: #f8fafc;
            border: 1px solid #edf2f7;
            border-radius: 8px;
            padding: 12px 14px;
            margin-right: 8px;
        }
        .info-box-right {
            background-color: #f8fafc;
            border: 1px solid #edf2f7;
            border-radius: 8px;
            padding: 12px 14px;
            margin-left: 8px;
        }
        .info-label {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #718096;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }
        .info-value {
            font-size: 12px;
            color: #1a202c;
            line-height: 1.5;
        }
        .txn-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .txn-table th {
            background-color: #750000;
            color: #ffffff;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 12px;
            text-align: left;
        }
        .txn-table th:last-child {
            text-align: right;
        }
        .txn-table td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
        }
        .txn-table td:last-child {
            text-align: right;
        }
        .amount-credit {
            color: #046c4e;
            font-weight: bold;
            font-size: 14px;
        }
        .amount-debit {
            color: #c81e1e;
            font-weight: bold;
            font-size: 14px;
        }
        .summary-table {
            width: 100%;
            margin-bottom: 24px;
        }
        .summary-table td {
            vertical-align: top;
        }
        .totals-box {
            width: 260px;
            margin-left: auto;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: #fcfdfd;
            padding: 12px;
        }
        .totals-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 11px;
        }
        .totals-row-final {
            display: flex;
            justify-content: space-between;
            padding-top: 6px;
            border-top: 1px dashed #cbd5e0;
            font-size: 13px;
            font-weight: bold;
            color: #750000;
        }
        .footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 16px;
            font-size: 10px;
            color: #718096;
            text-align: center;
        }
        .seal {
            display: inline-block;
            border: 2px dashed #d4af37;
            color: #750000;
            padding: 6px 12px;
            font-weight: bold;
            font-size: 10px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
            background-color: #fffdf5;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <!-- Header -->
        <div class="header">
            <table>
                <tr>
                    <td style="vertical-align: middle;">
                        <div class="brand-title">Rani Matrimonial</div>
                        <div class="brand-subtitle">Royal Privilege Matrimonial Service</div>
                    </td>
                    <td class="doc-title" style="vertical-align: middle;">
                        <h2>Payment Receipt</h2>
                        <p>Ref: #{{ $transaction->transaction_id }}</p>
                        <p style="margin-top: 2px;">Date: {{ $transaction->created_at->format('d M Y, h:i A') }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Candidate & Wallet Details -->
        <table class="info-grid">
            <tr>
                <td>
                    <div class="info-box">
                        <div class="info-label">Candidate Information</div>
                        <div class="info-value">
                            <strong>{{ $candidate->first_name }} {{ $candidate->last_name }}</strong><br>
                            Candidate Code: <strong>{{ $candidate->display_code ?? ('RM' . str_pad($candidate->id, 5, '0', STR_PAD_LEFT)) }}</strong><br>
                            Email: {{ $candidate->email }}<br>
                            Phone: {{ $candidate->phone ?? 'N/A' }}
                        </div>
                    </div>
                </td>
                <td>
                    <div class="info-box-right">
                        <div class="info-label">Wallet & Account Info</div>
                        <div class="info-value">
                            Privilege Card: <strong>{{ $wallet->formatted_card_number }}</strong><br>
                            Payment Mode: <strong>{{ $transaction->payment_method ?? 'Wallet' }}</strong><br>
                            Transaction Status: <span class="badge badge-success">{{ strtoupper($transaction->status) }}</span><br>
                            Type: <span class="badge {{ $transaction->type === 'credit' ? 'badge-credit' : 'badge-debit' }}">{{ strtoupper($transaction->type) }}</span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Transaction Table -->
        <table class="txn-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Description / Purpose</th>
                    <th style="width: 20%;">Category</th>
                    <th style="width: 15%; text-align: center;">Type</th>
                    <th style="width: 15%;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $transaction->title }}</strong>
                        @if($transaction->description)
                            <div style="font-size: 11px; color: #718096; margin-top: 3px;">
                                {{ $transaction->description }}
                            </div>
                        @endif
                    </td>
                    <td>
                        <span style="font-size: 11px; font-weight: 600; color: #4a5568;">{{ $transaction->category ?? 'General' }}</span>
                    </td>
                    <td style="text-align: center;">
                        <span class="badge {{ $transaction->type === 'credit' ? 'badge-credit' : 'badge-debit' }}">
                            {{ strtoupper($transaction->type) }}
                        </span>
                    </td>
                    <td>
                        <span class="{{ $transaction->type === 'credit' ? 'amount-credit' : 'amount-debit' }}">
                            {{ $transaction->type === 'credit' ? '+' : '-' }} ₹ {{ number_format($transaction->amount, 2) }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Totals & Balances -->
        <table class="summary-table">
            <tr>
                <td style="width: 55%; vertical-align: bottom;">
                    <div class="seal">
                        ✓ Verified & Authorized by Rani Matrimonial
                    </div>
                    <div style="font-size: 10px; color: #a0aec0; margin-top: 8px;">
                        This is a computer-generated official receipt. No physical signature required.
                    </div>
                </td>
                <td style="width: 45%;">
                    <table style="width: 100%; border: 1px solid #e2e8f0; border-radius: 8px; background-color: #f8fafc; padding: 10px;">
                        <tr>
                            <td style="padding: 4px; font-size: 11px; color: #718096;">Transaction Amount:</td>
                            <td style="padding: 4px; font-size: 12px; font-weight: bold; text-align: right;">
                                ₹ {{ number_format($transaction->amount, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; font-size: 11px; color: #718096;">Wallet Balance After:</td>
                            <td style="padding: 4px; font-size: 12px; font-weight: bold; text-align: right; color: #046c4e;">
                                ₹ {{ number_format($transaction->balance_after, 2) }}
                            </td>
                        </tr>
                        <tr style="border-top: 1px dashed #cbd5e0;">
                            <td style="padding: 6px 4px 2px 4px; font-size: 12px; font-weight: bold; color: #750000;">Total Settled:</td>
                            <td style="padding: 6px 4px 2px 4px; font-size: 13px; font-weight: bold; text-align: right; color: #750000;">
                                ₹ {{ number_format($transaction->amount, 2) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Rani Matrimonial Private Limited</strong> • Premier Matrimony & Matchmaking Portal</p>
            <p style="margin-top: 3px;">Helpline: +91 98765 43210 • Support: support@ranimatrimonial.com • Web: www.ranimatrimonial.com</p>
            <p style="margin-top: 4px; font-size: 9px; color: #a0aec0;">Generated on {{ now()->format('d M Y, h:i A') }}</p>
        </div>

    </div>
</body>
</html>
