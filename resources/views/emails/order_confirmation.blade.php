@extends('emails.layout')
@section('content')
    <h2>Order Confirmed & Invoice Generated</h2>
    <p>Hi {{ $order->client_name }},</p>
    <p>Thank you for your business! Your order has been processed. Here is your billing details statement:</p>
    
    <div class="highlight-box">
        <strong>Invoice Number:</strong> #{{ $order->order_number }}<br/>
        <strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}<br/>
        <strong>Status:</strong> Paid
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>Item / Description</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $order->service_name }} (Contract Base)</td>
                <td style="text-align: right;">${{ number_format($order->amount - $order->tax + $order->discount, 2) }}</td>
            </tr>
            @if ($order->discount > 0)
            <tr style="color: #ef4444;">
                <td>Coupon Discount</td>
                <td style="text-align: right;">-${{ number_format($order->discount, 2) }}</td>
            </tr>
            @endif
            @if ($order->tax > 0)
            <tr>
                <td>Integrated Tax (GST/Taxes)</td>
                <td style="text-align: right;">${{ number_format($order->tax, 2) }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="invoice-total">
        Total Paid: ${{ number_format($order->amount, 2) }}
    </div>

    @if ($order->billing_address)
    <div style="margin-top: 24px; font-size: 12px; color: #64748b;">
        <strong>Billing Address:</strong><br/>
        {{ $order->billing_address }}
    </div>
    @endif
@endsection
