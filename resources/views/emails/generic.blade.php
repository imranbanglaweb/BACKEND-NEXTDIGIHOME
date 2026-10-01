<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $companyName ?? 'গাড়িবন্ধু ৩৬০' }}</title>
    <style>
        /* Reset styles */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Color variables */
        :root {
            --primary-color: #1e3a5f;
            --secondary-color: #2d5a87;
            --accent-color: #3b82f6;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --border-color: #e2e8f0;
        }
        
        /* Mobile responsive */
        @media screen and (max-width: 600px) {
            .email-container { width: 100% !important; }
            .mobile-padding { padding: 20px 15px !important; }
            .mobile-stack { display: block !important; width: 100% !important; }
            .header-section { padding: 25px 20px !important; }
            .content-section { padding: 30px 20px !important; }
            .footer-section { padding: 20px !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    
    @php
        $settings = \App\Models\Setting::first();
        $logoUrl = $settings && $settings->admin_logo 
            ? asset('public/admin_resource/assets/images/' . $settings->admin_logo) 
            : null;
        $companyName = $companyName ?? ($settings && $settings->admin_title ? $settings->admin_title : 'গাড়িবন্ধু ৩৬০');
    @endphp
    
    <!-- Preheader -->
    <div style="display: none; max-height: 0; overflow: hidden;">
        {{ strip_tags($body ?? '') }}
    </div>

    <!-- Email Wrapper -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f1f5f9;">
        <tr>
            <td align="center" style="padding: 40px 15px;">
                
                <!-- Full Width Email Container -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" class="email-container" style="width: 100%; max-width: 700px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                    
                    <!-- Premium Header with Logo -->
                    <tr>
                        <td class="header-section" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); padding: 35px 40px; text-align: center;">
                            
                            @if($logoUrl)
                                <img src="{{ $logoUrl }}" 
                                     alt="{{ $companyName }}" 
                                     style="max-width: 200px; height: auto; display: inline-block; margin-bottom: 10px;">
                            @else
                                <!-- Default Logo Text -->
                                <h1 style="margin: 0 0 8px 0; color: #ffffff; font-size: 28px; font-weight: 700; letter-spacing: 0.5px;">
                                    {{ $companyName }}
                                </h1>
                            @endif
                            
                            <!-- Tagline -->
                            <p style="margin: 0; color: rgba(255,255,255,0.85); font-size: 14px; letter-spacing: 1px; text-transform: uppercase;">
                                All-in-One Fleet & Transport Automation System
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Main Content -->
                    <tr>
                        <td class="content-section mobile-padding" style="padding: 40px;">
                            <!-- Greeting -->
                            <h2 style="margin: 0 0 25px 0; color: var(--text-dark); font-size: 24px; font-weight: 700;">
                                Hello,
                            </h2>
                            
                            <!-- Body Content -->
                            <div style="color: var(--text-muted); font-size: 16px; line-height: 1.8; margin-bottom: 30px;">
                                {!! $body !!}
                            </div>
                            
                            <!-- Info Cards for Requisition Details -->
                            @isset($requisition)
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: var(--bg-light); border-radius: 12px; margin-bottom: 30px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td style="padding: 10px 0; border-bottom: 1px solid var(--border-color);">
                                                    <span style="color: var(--text-muted); font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Requisition Number</span>
                                                    <br>
                                                    <span style="color: var(--text-dark); font-size: 18px; font-weight: 700;">{{ $requisition->requisition_number ?? 'N/A' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; border-bottom: 1px solid var(--border-color);">
                                                    <span style="color: var(--text-muted); font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Status</span>
                                                    <br>
                                                    <span style="color: var(--accent-color); font-size: 16px; font-weight: 600;">{{ $requisition->status ?? 'Pending' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0;">
                                                    <span style="color: var(--text-muted); font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Travel Date</span>
                                                    <br>
                                                    <span style="color: var(--text-dark); font-size: 16px; font-weight: 600;">{{ isset($requisition->travel_date) ? \Carbon\Carbon::parse($requisition->travel_date)->format('M d, Y') : 'N/A' }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            @endisset
                            
                            <!-- Divider -->
                            <div style="margin: 25px 0; border-top: 1px solid var(--border-color);"></div>
                            
                            <!-- Action Button -->
                            @isset($action_url)
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td align="center" style="padding: 15px 0 25px 0;">
                                            <a href="{{ $action_url }}" 
                                               style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: #ffffff; text-decoration: none; font-size: 16px; font-weight: 600; border-radius: 10px; box-shadow: 0 4px 15px rgba(30, 58, 95, 0.4);">
                                                {{ $action_text ?? 'View Details' }}
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            @endisset
                            
                            <!-- Signature -->
                            <div style="margin-top: 30px; padding-top: 25px; border-top: 1px dashed var(--border-color);">
                                <p style="margin: 0 0 8px 0; color: var(--text-dark); font-size: 16px; font-weight: 600;">
                                    Best regards,
                                </p>
                                <p style="margin: 0; color: var(--text-muted); font-size: 14px;">
                                    The {{ $companyName }} Team
                                </p>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Premium Footer -->
                    <tr>
                        <td style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); padding: 30px 40px;">
                            <!-- Copyright & Links -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <p style="margin: 0 0 10px 0; color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600;">
                                            {{ $companyName }}
                                        </p>
                                        <p style="margin: 0 0 10px 0; color: rgba(255,255,255,0.8); font-size: 13px;">
                                            &copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.
                                        </p>
                                        <p style="margin: 0; color: rgba(255,255,255,0.6); font-size: 12px;">
                                            This is an automated message. Please do not reply directly to this email.
                                        </p>
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
