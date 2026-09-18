<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Received - Rani Matrimonial</title>
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
        .message-box { background: #faf5ee; border-left: 4px solid #d4af37; padding: 16px; border-radius: 8px; margin: 20px 0; font-size: 14px; line-height: 1.6; color: #3b0000; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 8px 12px; font-size: 13px; }
        .info-table tr:nth-child(even) { background-color: #f7efe4; border-radius: 6px; }
        .info-label { width: 35%; color: #78350f; font-weight: 600; }
        .info-val { width: 65%; color: #3b0000; font-weight: 600; }
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
                <div class="header-badge">Help & Support Desk</div>
                <h1>Thank You For Contacting Us</h1>
                <p>We have received your message and will respond promptly.</p>
            </div>
            <div class="content">
                <div class="greeting">Dear {{ $help->name }},</div>
                <p style="font-size: 14px; line-height: 1.6; color: #444;">
                    Thank you for reaching out to <strong>Rani Matrimonial</strong>. Our relationship & support team has received your inquiry and is reviewing your request. One of our representatives will contact you shortly.
                </p>

                <div style="font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #750000; margin-top: 20px; margin-bottom: 8px;">
                    📋 Your Inquiry Summary
                </div>
                <table class="info-table">
                    <tr>
                        <td class="info-label">Subject:</td>
                        <td class="info-val"><strong>{{ $help->subject }}</strong></td>
                    </tr>
                    <tr>
                        <td class="info-label">Phone:</td>
                        <td class="info-val">{{ $help->full_phone }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Email:</td>
                        <td class="info-val">{{ $help->email }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Date Submitted:</td>
                        <td class="info-val">{{ $help->created_at ? $help->created_at->format('d M, Y h:i A') : now()->format('d M, Y h:i A') }}</td>
                    </tr>
                </table>

                <div style="font-size: 13px; font-weight: 700; color: #4a0404;">Your Message:</div>
                <div class="message-box">
                    {!! nl2br(e($help->message)) !!}
                </div>

                <p style="font-size: 13px; color: #666; margin-top: 20px; line-height: 1.5;">
                    If your inquiry is urgent, you can also reach us directly at <strong style="color: #750000;">sumatra.sales2424@gmail.com</strong>.
                </p>
            </div>
            <div class="footer">
                <p style="margin: 0 0 6px 0; font-weight: 600;">Rani Matrimonial Help & Relationship Center</p>
                <p style="margin: 0; font-size: 11px; opacity: 0.85;">© {{ date('Y') }} Rani Matrimonial. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
