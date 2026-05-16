<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>
/* Reset styles */
table {
    border-collapse: collapse;
}
a {
    text-decoration: none;
}
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f6f8;
    margin: 0;
    padding: 20px;
}
/* Premium button styles */
.button {
    display: inline-block;
    padding: 14px 28px;
    background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
    color: #ffffff !important;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 15px;
    text-align: center;
}
/* Responsive styles */
@media only screen and (max-width: 600px) {
    .inner-body {
        width: 100% !important;
    }
    .footer {
        width: 100% !important;
    }
    .wrapper {
        padding: 10px !important;
    }
}

@media only screen and (max-width: 500px) {
    .button {
        width: 100% !important;
    }
    .header-text {
        font-size: 20px !important;
    }
    .email-container {
        border-radius: 8px !important;
    }
}
</style>
</head>
<body>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">

<!-- Email Container with Premium Card Style -->
<table class="email-container" width="100%" cellpadding="0" cellspacing="0" style="max-width: 650px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);">

<!-- Premium Header with Gradient -->
<tr>
<td class="email-header" style="background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%); padding: 35px 40px; text-align: center;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                @php
                    $settings = \App\Models\Setting::first();
                    $logoUrl = $settings && $settings->admin_logo 
                        ? asset('public/admin_resource/assets/images/' . $settings->admin_logo) 
                        : null;
                    $adminTitle = $settings && $settings->admin_title ? $settings->admin_title : 'গাড়িবন্ধু ৩৬০';
                @endphp
                
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{ $adminTitle }}" style="max-width: 200px; height: auto; margin-bottom: 10px;">
                @else
                    <h1 style="margin: 0 0 8px 0; font-size: 28px; font-weight: 700; color: #ffffff;">{{ $adminTitle }}</h1>
                @endif
                <p style="margin: 0; color: rgba(255,255,255,0.85); font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">Vehicle Management System</p>
            </td>
        </tr>
    </table>
</td>
</tr>

<!-- Email Body -->
<tr>
<td class="body" style="padding: 35px 40px;">
<table class="inner-body" align="center" width="100%" cellpadding="0" cellspacing="0">
<tr>
<td class="content-cell" style="color: #64748b; font-size: 16px; line-height: 1.8;">
{{ Illuminate\Mail\Markdown::parse($slot) }}
{{ $subcopy ?? '' }}
</td>
</tr>
</table>
</td>
</tr>

<!-- Premium Footer with Gradient -->
<tr>
<td class="email-footer" style="background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%); padding: 30px 40px; text-align: center;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                @php
                    $settings = \App\Models\Setting::first();
                    $adminTitle = $settings && $settings->admin_title ? $settings->admin_title : 'গাড়িবন্ধু ৩৬০';
                    $year = date('Y');
                @endphp
                <p style="margin: 0 0 5px 0; font-size: 13px; color: rgba(255,255,255,0.8);">&copy; {{ $year }} {{ $adminTitle }}. All rights reserved.</p>
                <small style="color: rgba(255,255,255,0.6); font-size: 12px;">This is an automated message. Please do not reply directly to this email.</small>
            </td>
        </tr>
    </table>
</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>
