<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vault Document Register Tracking System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            width: 100%;
            height: 100%;
        }
        .wrapper {
            width: 100%;
            background: #f5f5f5;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #1e4b75 0%, #17a2b8 100%);
            color: white;
            padding: 30px;
            text-align: center;
            width: 100%;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin-top: 10px;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            background: #ffffff;
            padding: 40px;
            width: 100%;
        }
        .status-badge {
            text-align: center;
            margin: 20px 0 30px;
        }
        .status-badge span {
            background: #28a745;
            color: white;
            padding: 10px 30px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 500;
            display: inline-block;
        }
        .section {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 25px;
            margin: 30px 0;
            width: 100%;
        }
        .section-title {
            color: #1e4b75;
            font-size: 20px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }
        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            padding: 12px 15px;
            font-weight: 600;
            color: #555;
            width: 200px;
            border-bottom: 1px solid #eee;
        }
        .info-value {
            display: table-cell;
            padding: 12px 15px;
            color: #333;
            border-bottom: 1px solid #eee;
        }
        .document-preview {
            margin: 30px 0;
            text-align: center;
        }
        .document-preview img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .action-button {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            padding: 15px 35px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .footer {
            background: #f8f9fa;
            padding: 25px;
            text-align: center;
            border-top: 1px solid #e9ecef;
            width: 100%;
        }
        .footer p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        @media only screen and (max-width: 600px) {
            .wrapper { padding: 10px; }
            .content { padding: 20px; }
            .info-label, .info-value {
                display: block;
                width: 100%;
                padding: 8px;
            }
            .button { padding: 12px 25px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>Vault Document Register Tracking System</h1>
            <p>{{ $appName }}</p>
        </div>

        <div class="content">
            <div class="status-badge">
                <span>✓ APPROVED</span>
            </div>

            <h2>Dear Sir {{ $recipientName }},</h2>
            <p style="margin: 20px 0;">Your document has been successfully Tracking Our System. Please find the details information below:</p>

            <div class="section">
                <h3 class="section-title">Document Information</h3>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Document Type</div>
                        <div class="info-value">{{ $documentType }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Project Name</div>
                        <div class="info-value">{{ $projectName }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Land Details</div>
                        <div class="info-value">{{ $landName }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Vault Number</div>
                        <div class="info-value">{{ $document->vault_number }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Vault Location</div>
                        <div class="info-value">{{ $document->vault_location }}</div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Approval Details</h3>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Document Taker</div>
                        <div class="info-value">{{ $documentTaker }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Approved By</div>
                        <div class="info-value">{{ $approverName }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Approval Date</div>
                        <div class="info-value">{{ $approvalDate }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Return Date</div>
                        <div class="info-value">{{ $document->proposed_return_date->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            @if($document->withdrawal_reason)
            <div class="section">
                <h3 class="section-title">Withdrawal Reason</h3>
                <p style="padding: 10px;">{!! $document->withdrawal_reason !!}</p>
            </div>
            @endif

            @if($document->document_scan)
            <div class="section">
                <h3 class="section-title">Document Preview</h3>
                <div class="document-preview">
                    <img src="{{ $message->embed(storage_path('app/documents/' . $document->document_scan)) }}" 
                         alt="Document Scan">
                </div>
            </div>
            @endif

        {{--     <div class="action-button">
                <a href="{{ $url }}" class="button">View Complete Document</a>
            </div> --}}

            <div class="footer">
                <p>This is an automated message from {{ $appName }}.</p>
                <p>Please do not reply to this email.</p>
                <p>&copy; {{ date('Y') }} Department of IT Unique Group. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html> 