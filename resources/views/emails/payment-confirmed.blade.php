<!DOCTYPE html>
<html>
<head>
    <title>Payment Confirmed</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px; max-width: 600px; margin: 0 auto;">
    <div style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="width: 80px; height: 80px; background: #28a745; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                <i class="fa fa-check" style="color: white; font-size: 40px;"></i>
            </div>
        </div>
        
        <h2 style="color: #333; text-align: center; margin-bottom: 20px;">Payment Confirmed!</h2>
        
        <p style="color: #666; font-size: 16px; line-height: 1.6;">
            Dear <strong>{{ $company->name }}</strong>,
        </p>
        
        <p style="color: #666; font-size: 16px; line-height: 1.6;">
            Your payment has been confirmed and your subscription is now active.
        </p>
        
        <div style="background: white; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 10px 0; color: #666;">Plan</td>
                    <td style="padding: 10px 0; text-align: right; font-weight: bold; color: #333;">{{ $plan->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #666;">Amount Paid</td>
                    <td style="padding: 10px 0; text-align: right; font-weight: bold; color: #28a745;">৳{{ number_format($payment->amount) }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #666;">Transaction ID</td>
                    <td style="padding: 10px 0; text-align: right; color: #333;">{{ $payment->transaction_id }}</td>
                </tr>
            </table>
        </div>
        
        <p style="color: #666; font-size: 16px; line-height: 1.6;">
            Your subscription is now active. You can access all features of the <strong>{{ $plan->name }}</strong> plan.
        </p>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('home') }}" style="display: inline-block; background: #0d6efd; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                Go to Dashboard
            </a>
        </div>
        
        <hr style="border: none; border-top: 1px solid #dee2e6; margin: 30px 0;">
        
        <p style="color: #999; font-size: 12px; text-align: center;">
            If you have any questions, please contact our support team.
        </p>
    </div>
</body>
</html>