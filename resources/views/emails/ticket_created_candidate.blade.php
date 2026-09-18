<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Ticket Raised - Rani Matrimonial</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f5eee6; font-family: 'Outfit', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #1a0000; -webkit-font-smoothing: antialiased; }
        .wrapper { width: 100%; background-color: #f5eee6; padding: 36px 12px; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #fdfbf7; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(74, 4, 4, 0.12); border: 1px solid rgba(212, 175, 55, 0.35); }
        .header { background: linear-gradient(135deg, #4a0404 0%, #750000 55%, #3b0000 100%); padding: 32px 24px; text-align: center; color: #ffffff; border-bottom: 3px solid #d4af37; }
        .header-logo { max-height: 55px; max-width: 180px; object-fit: contain; }
        .header-badge { display: inline-block; background: rgba(212, 175, 55, 0.18); border: 1px solid #d4af37; color: #f9f1d8; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; padding: 4px 16px; border-radius: 20px; margin-bottom: 10px; }
        .header h1 { margin: 0 0 6px 0; font-size: 22px; font-weight: 700; color: #fdfbf7; font-family: 'Playfair Display', Georgia, serif; }
        .header p { margin: 0; font-size: 13px; color: #f9f1d8; opacity: 0.92; }
        .content { padding: 28px 24px; }
        .greeting { font-size: 16px; font-weight: 700; color: #4a0404; margin-bottom: 12px; }
        .ticket-code-card { background: linear-gradient(135deg, #fffdf8 0%, #fef8eb 100%); border: 2px solid #d4af37; border-radius: 14px; padding: 20px; text-align: center; margin: 20px 0; box-shadow: 0 4px 14px rgba(212, 175, 55, 0.12); }
        .ticket-code-val { font-family: 'Courier New', Courier, monospace; font-size: 24px; font-weight: 900; color: #750000; letter-spacing: 2px; margin: 6px 0; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 8px 12px; font-size: 13px; }
        .info-table tr:nth-child(even) { background-color: #f7efe4; border-radius: 6px; }
        .info-label { width: 35%; color: #78350f; font-weight: 600; }
        .info-val { width: 65%; color: #3b0000; font-weight: 600; }
        .message-box { background: #faf5ee; border-left: 4px solid #750000; padding: 14px 16px; border-radius: 8px; margin: 15px 0; font-size: 13px; line-height: 1.6; color: #3b0000; }
        .btn-action { display: block; width: fit-content; margin: 25px auto 10px auto; background: linear-gradient(135deg, #d4af37 0%, #c59b27 50%, #b8860b 100%); color: #3b0000 !important; text-decoration: none; padding: 12px 30px; font-size: 14px; font-weight: 800; border-radius: 9999px; text-align: center; }
        .footer { background: linear-gradient(135deg, #f9f1d8 0%, #f4e8c5 100%); padding: 20px; text-align: center; border-top: 1.5px solid rgba(212, 175, 55, 0.4); font-size: 12px; color: #5c0a0a; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="email-container">
            <div class="header">
                <div style="margin-bottom: 10px;">
                    @php
                        $logoPath = public_path('logo.png');
                        $hasLogo = file_exists($logoPath);
                        $logoSrc = (isset($message) && $hasLogo) ? $message->embed($logoPath) : asset('logo.png');
                    @endphp
                    <img src="{{ $logoSrc }}" alt="Rani Matrimonial" class="header-logo">
                </div>
                <div class="header-badge">Support Desk</div>
                <h1>Thank You For Raising A Ticket</h1>
                <p>Your support request has been logged successfully</p>
            </div>
            <div class="content">
                <div class="greeting">Dear {{ $candidate->first_name }} {{ $candidate->last_name }},</div>
                <p style="font-size: 14px; line-height: 1.6; color: #444;">
                    Thank you for reaching out to our support team. We have registered your ticket and assigned a dedicated representative to assist you.
                </p>

                <!-- Dynamic Ticket Code Card -->
                <div class="ticket-code-card">
                    <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: #78350f;">
                        Your Dynamic Ticket Number
                    </div>
                    <div class="ticket-code-val">{{ $ticket->ticket_code }}</div>
                    <div style="font-size: 12px; color: #555;">
                        Please quote this ticket number in all future communications.
                    </div>
                </div>

                <div style="font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #750000; margin-bottom: 8px;">
                    📋 Ticket Details
                </div>
                <table class="info-table">
                    <tr>
                        <td class="info-label">Candidate Code:</td>
                        <td class="info-val"><strong style="color: #750000;">{{ $candidate->display_code }}</strong></td>
                    </tr>
                    <tr>
                        <td class="info-label">Subject:</td>
                        <td class="info-val"><strong>{{ $ticket->subject ?? 'Support Inquiry' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="info-label">Priority:</td>
                        <td class="info-val">
                            <strong style="text-transform: uppercase; color: {{ $ticket->priority === 'urgent' ? '#dc2626' : ($ticket->priority === 'high' ? '#d97706' : '#2563eb') }};">
                                {{ $ticket->priority }}
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Status:</td>
                        <td class="info-val"><span style="color: #d97706; font-weight: 700;">Open / Under Review</span></td>
                    </tr>
                    <tr>
                        <td class="info-label">Date Created:</td>
                        <td class="info-val">{{ $ticket->created_at ? $ticket->created_at->format('d M, Y h:i A') : now()->format('d M, Y h:i A') }}</td>
                    </tr>
                </table>

                <div style="font-size: 13px; font-weight: 700; color: #4a0404;">Ticket Description:</div>
                <div class="message-box">
                    {!! nl2br(e($ticket->message)) !!}
                </div>

                @if(!empty($ticket->screenshots) && count($ticket->screenshots) > 0)
                    <div style="font-size: 12px; color: #78350f; font-weight: 600; margin-top: 10px;">
                        📎 {{ count($ticket->screenshots) }} Attachment(s) / Screenshot(s) uploaded.
                    </div>
                @endif

                <a href="{{ url('/support') }}" class="btn-action">
                    View Ticket in Support Center →
                </a>
            </div>
            <div class="footer">
                <p style="margin: 0 0 6px 0; font-weight: 600;">Rani Matrimonial Candidate Support</p>
                <p style="margin: 0; font-size: 11px; opacity: 0.85;">© {{ date('Y') }} Rani Matrimonial. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
