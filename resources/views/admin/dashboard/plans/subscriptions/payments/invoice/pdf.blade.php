<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th { background: #f5f5f5; }
        .total { font-weight: bold; }
    </style>
</head>
<body>

<div class="header">
    <h2>Payment Invoice</h2>
    <p>Invoice #{{ $payment->id }}</p>
</div>

<table class="table">
<tr>
    <th>Company</th>
    <td>{{ $payment->company->name }}</td>
</tr>
<tr>
    <th>Customer</th>
    <td>{{ $payment->user->name }}</td>
</tr>
<tr>
    <th>Plan</th>
    <td>{{ $payment->plan->name }}</td>
</tr>
<tr>
    <th>Payment Method</th>
    <td>{{ strtoupper($payment->method) }}</td>
</tr>
<tr>
    <th>Transaction ID</th>
    <td>{{ $payment->transaction_id }}</td>
</tr>
<tr class="total">
    <th>Amount</th>
    <td>{{ number_format($payment->amount, 2) }} {{ $payment->currency }}</td>
</tr>
</table>

<br>

<p>
    <strong>Paid At:</strong>
    {{ $payment->updated_at->format('d M Y') }}
</p>

</body>
</html>
