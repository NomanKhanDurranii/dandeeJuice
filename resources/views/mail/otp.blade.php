<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your DandeeJuice Login Code</title>
<style>
  body { margin: 0; padding: 0; background: #f9fafb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
  .wrapper { max-width: 480px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
  .header { background: linear-gradient(135deg, #f97316, #fb923c); padding: 32px 40px; text-align: center; }
  .header h1 { color: #fff; margin: 0; font-size: 26px; font-weight: 800; letter-spacing: -.5px; }
  .header p { color: rgba(255,255,255,.85); margin: 4px 0 0; font-size: 13px; }
  .body { padding: 36px 40px; text-align: center; }
  .body p { color: #6b7280; font-size: 15px; margin: 0 0 24px; }
  .otp-box { display: inline-block; background: #fff7ed; border: 2px dashed #fb923c; border-radius: 12px; padding: 20px 40px; margin-bottom: 24px; }
  .otp-code { font-size: 48px; font-weight: 900; letter-spacing: 12px; color: #ea580c; font-family: 'Courier New', monospace; }
  .note { font-size: 13px; color: #9ca3af; }
  .footer { background: #f9fafb; border-top: 1px solid #f3f4f6; padding: 20px 40px; text-align: center; font-size: 12px; color: #9ca3af; }
</style>
</head>
<body>
  <div class="wrapper">
    <div class="header">
      <h1>DandeeJuice 🍊</h1>
      <p>Fresh Juices · Pure Joy</p>
    </div>
    <div class="body">
      <p>Use the code below to sign in to your account. It expires in <strong>{{ $expiresInMinutes }} minutes</strong>.</p>
      <div class="otp-box">
        <div class="otp-code">{{ $otp }}</div>
      </div>
      <p class="note">If you didn't request this, you can safely ignore this email.</p>
    </div>
    <div class="footer">
      &copy; {{ date('Y') }} DandeeJuice. All rights reserved.
    </div>
  </div>
</body>
</html>
