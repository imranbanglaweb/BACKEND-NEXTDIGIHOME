<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Requisition Status Update</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            padding: 20px;
        }
        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
            padding: 35px 40px;
            text-align: center;
        }
        .logo {
            max-width: 200px;
            height: auto;
            margin-bottom: 10px;
        }
        .company-name {
            color: #ffffff;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .tagline {
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .email-body {
            padding: 35px 40px;
        }
        .greeting {
            color: #1e293b;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .message {
            color: #64748b;
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 25px;
        }
        .status-box {
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            text-align: center;
        }
        .status-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        .status-value {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
        }
        .details-section {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid #e2e8f0;
        }
        .section-title {
            color: #1e293b;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e2e8f0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e8e8f0;
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
            text-align: right;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 16px 35px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            margin: 25px 0;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 58, 95, 0.3);
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 95, 0.4);
        }
        .email-footer {
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
            padding: 30px 40px;
            text-align: center;
        }
        .footer-text {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            line-height: 1.6;
        }
        .footer-text a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }
        .footer-company {
            color: #ffffff;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100%;
            }
            .email-header, .email-body, .email-footer {
                padding: 25px 20px;
            }
            .detail-row {
                flex-direction: column;
            }
            .detail-value {
                text-align: left;
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    @php
        $settings = \App\Models\Setting::first();
        $logoUrl = $settings && $settings->admin_logo 
            ? asset('public/admin_resource/assets/images/' . $settings->admin_logo) 
            : null;
        $companyName = $companyName ?? ($settings && $settings->admin_title ? $settings->admin_title : 'গাড়িবন্ধু ৩৬০');
    @endphp
    
    <div class="email-container">
        <!-- Header with Logo -->
        <div class="email-header">
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $companyName }}" class="logo">
            @else
                <div class="company-name">{{ $companyName }}</div>
            @endif
            <div class="tagline">All-in-One Fleet & Transport Automation System</div>
        </div>

        <!-- Email Body -->
        <div class="email-body">
            <div class="greeting">Dear {{ $req->requestedBy->name ?? 'User' }},</div>

            <div class="message">
                Your vehicle requisition request status has been updated. Please find the details below:
            </div>

            <!-- Status Box -->
            <div class="status-box">
                <div class="status-label">Current Status</div>
                <div class="status-value">{{ $newStatus }}</div>
            </div>

            <!-- Requisition Details -->
            <div class="details-section">
                <div class="section-title">Requisition Details</div>
                
                <div class="detail-row">
                    <span class="detail-label">Requisition Number</span>
                    <span class="detail-value">{{ $req->requisition_number ?? 'N/A' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Requested By</span>
                    <span class="detail-value">{{ $req->requestedBy->name ?? 'N/A' }}</span>
                </div>
                
                @if($req->department)
                <div class="detail-row">
                    <span class="detail-label">Department</span>
                    <span class="detail-value">{{ $req->department->department_name ?? 'N/A' }}</span>
                </div>
                @endif
                
                <div class="detail-row">
                    <span class="detail-label">From Location</span>
                    <span class="detail-value">{{ $req->from_location ?? 'N/A' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Drop-off Location</span>
                    <span class="detail-value">{{ $req->to_location ?? 'N/A' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Date & Time</span>
                    <span class="detail-value">
                        @if($req->travel_date)
                            {{ \Carbon\Carbon::parse($req->travel_date)->format('d M, Y') }}
                            @if($req->travel_time)
                                at {{ \Carbon\Carbon::parse($req->travel_time)->format('h:i A') }}
                            @endif
                        @else
                            N/A
                        @endif
                    </span>
                </div>
                
                @if($req->purpose)
                <div class="detail-row" style="flex-direction: column;">
                    <span class="detail-label">Purpose</span>
                    <span class="detail-value" style="text-align: left; margin-top: 8px;">{{ $req->purpose }}</span>
                </div>
                @endif
                
                <div class="detail-row">
                    <span class="detail-label">Passengers</span>
                    <span class="detail-value">{{ $req->number_of_passenger ?? 0 }} passenger(s)</span>
                </div>
            </div>

            @if($comment)
            <div class="details-section">
                <div class="section-title">Comments</div>
                <p style="color: #64748b; font-size: 14px; line-height: 1.6;">{{ $comment }}</p>
            </div>
            @endif

            <!-- CTA Button -->
            <div style="text-align: center;">
                <a href="{{ url(route('requisitions.show', $req->id)) }}" class="cta-button">
                    Review & Approve Requisition
                </a>
            </div>

            <div class="message" style="margin-top: 20px; margin-bottom: 0;">
                Please review the requisition details and take appropriate action within your department.
            </div>
        </div>

        <!-- Email Footer -->
        <div class="email-footer">
            <p class="footer-company">{{ $companyName }}</p>
            <p class="footer-text">
                This is an automated message from {{ $companyName }}.<br>
                If you have any questions, please contact your system administrator.<br>
                <br>
                &copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
