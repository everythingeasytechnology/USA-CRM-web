@extends('emails.layout')
@section('content')
    <h2>Thank you, {{ $lead->name }}!</h2>
    <p>We've received your project inquiry for <strong>{{ $lead->service_requested }}</strong>.</p>
    <p>One of our Technical Architects is reviewing your budget specs and local requirements. We will get back to you with a custom strategy proposal within 1 business day.</p>
    <div class="highlight-box">
        <strong>Inquiry Details:</strong><br/>
        - Budget Scope: {{ $lead->budget }}<br/>
        - Mapped Location: {{ $lead->country }}
    </div>
    <p>Best Regards,<br/><strong>EverythingEasy Business Team</strong></p>
@endsection
