@extends('emails.layout')
@section('content')
    <h2>New Contact Submission Received</h2>
    <p>A user has filled out the contact form on the website. Here are the submission details:</p>
    <div class="highlight-box">
        <strong>Name:</strong> {{ $data['name'] }}<br/>
        <strong>Email:</strong> {{ $data['email'] }}<br/>
        <strong>Phone:</strong> {{ $data['phone'] ?? '—' }}<br/>
        <strong>Subject:</strong> {{ $data['subject'] ?? 'General Inquiry' }}<br/>
        <strong>Message:</strong><br/>
        {{ $data['message'] }}
    </div>
@endsection
