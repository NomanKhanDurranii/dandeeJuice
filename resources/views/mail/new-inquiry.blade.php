<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>New Inquiry</title>
<style>
  body{margin:0;padding:0;background:#f9fafb;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;}
  .wrap{max-width:520px;margin:40px auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08);}
  .hdr{background:linear-gradient(135deg,#f97316,#fb923c);padding:24px 32px;}
  .hdr h1{color:#fff;margin:0;font-size:20px;font-weight:800;}
  .hdr p{color:rgba(255,255,255,.8);margin:4px 0 0;font-size:13px;}
  .body{padding:28px 32px;}
  .row{margin-bottom:16px;}
  .label{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:#9ca3af;margin-bottom:4px;}
  .value{font-size:14px;color:#374151;}
  .msg-box{background:#f9fafb;border:1px solid #f3f4f6;border-radius:10px;padding:14px;font-size:14px;color:#374151;line-height:1.6;white-space:pre-wrap;}
  .btn{display:inline-block;background:#f97316;color:#fff;text-decoration:none;font-weight:700;padding:12px 24px;border-radius:10px;font-size:14px;}
  .footer{background:#f9fafb;border-top:1px solid #f3f4f6;padding:16px 32px;font-size:12px;color:#9ca3af;text-align:center;}
</style>
</head>
<body>
<div class="wrap">
  <div class="hdr">
    <h1>📩 New Inquiry Received</h1>
    <p>Someone submitted the contact form on DandeeJuice</p>
  </div>
  <div class="body">
    <div class="row"><div class="label">From</div><div class="value">{{ $inquiry->name }}</div></div>
    <div class="row"><div class="label">Email</div><div class="value">{{ $inquiry->email }}</div></div>
    @if($inquiry->phone)
    <div class="row"><div class="label">Phone</div><div class="value">{{ $inquiry->phone }}</div></div>
    @endif
    <div class="row"><div class="label">Subject</div><div class="value">{{ $inquiry->subject }}</div></div>
    <div class="row">
      <div class="label">Message</div>
      <div class="msg-box">{{ $inquiry->message }}</div>
    </div>
    <div style="margin-top:24px;">
      <a href="{{ url('/admin/inquiries/'.$inquiry->id.'/edit') }}" class="btn">View in Admin →</a>
    </div>
  </div>
  <div class="footer">&copy; {{ date('Y') }} DandeeJuice Admin</div>
</div>
</body>
</html>
