<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Department Head Assignment</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.7;
            color: #1e293b;
            background-color: #f1f5f9;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            padding: 40px 20px;
        }
        .container {
            max-width: 640px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }
        .header {
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
            color: white;
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            animation: pulse 4s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        .header-content {
            position: relative;
            z-index: 1;
        }
        .header-logo {
            max-width: 200px;
            height: auto;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 50px 40px;
        }
        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 25px;
        }
        .intro-text {
            color: #475569;
            font-size: 16px;
            margin-bottom: 30px;
        }
        .card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 16px;
            padding: 30px;
            margin: 30px 0;
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1e3a5f, #2d5a87);
        }
        .card-title {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1e3a5f;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }
        .detail-value {
            color: #1e293b;
            font-size: 14px;
            font-weight: 600;
        }
        .responsibilities {
            background: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 30px;
            margin: 30px 0;
        }
        .responsibilities h3 {
            color: #1e293b;
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 20px;
        }
        .responsibilities ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .responsibilities li {
            display: flex;
            align-items: flex-start;
            padding: 12px 0;
            color: #475569;
            font-size: 15px;
        }
        .responsibilities li::before {
            content: '✓';
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, #1e3a5f, #2d5a87);
            color: white;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 12px;
            flex-shrink: 0;
        }
        .cta-section {
            text-align: center;
            padding: 20px 0;
            margin: 40px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
            color: white;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 10px 25px -5px rgba(30, 58, 95, 0.4);
            transition: all 0.3s ease;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 35px -5px rgba(30, 58, 95, 0.5);
        }
        .footer {
            background-color: #f8fafc;
            padding: 40px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .footer-logo {
            font-size: 24px;
            font-weight: 700;
            color: #1e3a5f;
            margin-bottom: 15px;
        }
        .footer p {
            margin: 8px 0;
            font-size: 14px;
            color: #64748b;
        }
        .footer a {
            color: #1e3a5f;
            text-decoration: none;
        }
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            margin: 30px 0;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 0 10px;
            }
            .header, .content, .footer {
                padding: 30px 20px;
            }
            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <div class="header-content">
                    @php
                        $settings = \App\Models\Setting::first();
                        $logoUrl = $settings && $settings->admin_logo 
                            ? asset('public/admin_resource/assets/images/' . $settings->admin_logo) 
                            : null;
                        $companyName = $companyName ?? ($settings && $settings->admin_title ? $settings->admin_title : 'গাড়িবন্ধু ৩৬০');
                    @endphp
                    
                    @if($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $companyName }}" class="header-logo">
                    @else
                        <h1>{{ $companyName }}</h1>
                    @endif
                    <p>All-in-One Fleet & Transport Automation System</p>
                </div>
            </div>
            
            <div class="content">
                <div class="greeting">Dear {{ $headName }},</div>
                
                <p class="intro-text">Congratulations! We are pleased to inform you that you have been appointed as the <strong style="color: #1e3a5f;">Department Head</strong>. This appointment reflects your dedication and leadership capabilities.</p>
                
                <div class="card">
                    <div class="card-title">Assignment Details</div>
                    <div class="detail-row">
                        <span class="detail-label">Department</span>
                        <span class="detail-value">{{ $departmentName }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Effective Date</span>
                        <span class="detail-value">{{ now()->format('F d, Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Assigned By</span>
                        <span class="detail-value">{{ $companyName }} Administration</span>
                    </div>
                </div>
                
                <div class="responsibilities">
                    <h3><i class="fa fa-tasks" style="margin-right: 10px; color: #1e3a5f;"></i>Key Responsibilities</h3>
                    <ul>
                        <li>Review and approve requisitions submitted by your department team</li>
                        <li>Coordinate with transport and logistics for smooth operations</li>
                        <li>Monitor and optimize departmental workflows and processes</li>
                        <li>Provide leadership and guidance to department members</li>
                        <li>Ensure timely completion of all department-related tasks</li>
                    </ul>
                </div>
                
                <p style="color: #475569; font-size: 15px;">You will receive automatic email notifications whenever new requisitions require your attention or approval.</p>
                
                <div class="cta-section">
                    <a href="{{ route('dashboard') }}" class="button">
                        <i class="fa fa-dashboard" style="margin-right: 10px;"></i>Access Dashboard
                    </a>
                </div>
                
                <p style="color: #64748b; font-size: 14px;">If you have any questions or need clarification about your new responsibilities, please don't hesitate to reach out to the administration team.</p>
                
                <div class="divider"></div>
                
                <p style="color: #1e293b; font-size: 16px; font-weight: 600;">
                    Best regards,<br>
                    <span style="color: #1e3a5f;">{{ $companyName }} Team</span>
                </p>
            </div>
            
            <div class="footer">
                <div class="footer-logo">{{ $companyName }}</div>
                <p>This is an automated message from {{ $companyName }}</p>
                <p>Please do not reply directly to this email.</p>
                <p>&copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
