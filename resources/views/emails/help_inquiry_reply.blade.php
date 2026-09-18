<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response to your Inquiry - Rani Matrimonial</title>
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
        .reply-box { background: linear-gradient(135deg, #fffdf8 0%, #fef8eb 100%); border: 1.5px solid #d4af37; border-left: 5px solid #c59b27; padding: 18px 20px; border-radius: 12px; margin: 20px 0; font-size: 14px; line-height: 1.6; color: #3b0000; box-shadow: 0 4px 12px rgba(212, 175, 55, 0.08); }
        .original-box { background: #faf5ee; border-left: 3px solid #999; padding: 12px 16px; border-radius: 6px; margin: 15px 0; font-size: 13px; line-height: 1.5; color: #666; }
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
                <div class="header-badge">Customer Support Response</div>
                <h1>Response To Your Inquiry</h1>
                <p>Re: {{ $help->subject }}</p>
            </div>
            <div class="content">
                <div class="greeting">Dear {{ $help->name }},</div>
                <p style="font-size: 14px; line-height: 1.6; color: #444;">
                    Our support team has reviewed your inquiry regarding <strong>"{{ $help->subject }}"</strong>. Here is the response from our administrative team:
                </p>

                <div style="font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #750000; margin-top: 18px;">
                    💬 Response From Rani Matrimonial Support:
                </div>
                <div class="reply-box">
                    {!! nl2br(e($replyMessage)) !!}
                </div>

                <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #777; margin-top: 24px;">
                    Original Inquiry Message:
                </div>
                <div class="original-box">
                    {!! nl2br(e($help->message)) !!}
                </div>

                <p style="font-size: 13px; color: #666; margin-top: 20px; line-height: 1.5;">
                    If you have further questions or require additional assistance, feel free to reply to this email or visit our Help Center.
                </p>
            </div>
            <div class="footer">
                <p style="margin: 0 0 6px 0; font-weight: 600;">Rani Matrimonial Help & Support Team</p>
                <p style="margin: 0; font-size: 11px; opacity: 0.85;">© {{ date('Y') }} Rani Matrimonial. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
