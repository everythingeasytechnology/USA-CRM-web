@extends('emails.layout')
@section('content')
    <h2>Hi {{ $data['name'] }},</h2>
    <p>Thank you for getting in touch with us! We have received your message and our team will review it shortly.</p>
    <p>Normally, we reply to all inquiries within 24 business hours. If your request is urgent, please feel free to call our direct customer helpline.</p>
    <div class="highlight-box">
        <strong>Your message subject:</strong> {{ $data['subject'] ?? 'General Inquiry' }}
    </div>
    <p>Best Regards,<br/><strong>EverythingEasy Team</strong></p>
@endsection
