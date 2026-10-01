<!DOCTYPE html>
<html>
<head>
    <title>Payment Approved Notification</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px; max-width: 600px; margin: 0 auto;">
    <div style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
        <h2 style="color: #333; margin-bottom: 20px;">New Payment Approved</h2>
        
        <p style="color: #666; font-size: 16px; line-height: 1.6;">
            A payment has been approved and the subscription is now active.
        </p>
        
        <div style="background: white; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 10px 0; color: #666;">Company</td>
                    <td style="padding: 10px 0; text-align: right; font-weight: bold; color: #333;">{{ $company->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #666;">Plan</td>
                    <td style="padding: 10px 0; text-align: right; font-weight: bold; color: #333;">{{ $plan->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #666;">Amount</td>
                    <td style="padding: 10px 0; text-align: right; font-weight: bold; color: #28a745;">৳{{ number_format($payment->amount) }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #666;">Transaction ID</td>
                    <td style="padding: 10px 0; text-align: right; color: #333;">{{ $payment->transaction_id }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #666;">Approved At</td>
                    <td style="padding: 10px 0; text-align: right; color: #333;">{{ now()->format('d M Y h:i A') }}</td>
                </tr>
            </table>
        </div>
        
        <p style="color: #999; font-size: 12px;">
            View this payment in the admin dashboard.
        </p>
    </div>
</body>
</html>