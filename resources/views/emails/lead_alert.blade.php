@extends('emails.layout')
@section('content')
    <h2>New Project Lead Received <span class="badge">New</span></h2>
    <p>A new lead inquiry has been registered. Review details below:</p>
    <div class="highlight-box">
        <strong>Client Name:</strong> {{ $lead->name }}<br/>
        <strong>Email:</strong> {{ $lead->email }}<br/>
        <strong>Phone:</strong> {{ $lead->phone ?? '—' }}<br/>
        <strong>Service Requested:</strong> {{ $lead->service_requested }}<br/>
        <strong>Declared Budget:</strong> {{ $lead->budget }}<br/>
        <strong>Country:</strong> {{ $lead->country }}<br/>
        <strong>Lead Source:</strong> {{ $lead->source }}<br/>
        <strong>Notes:</strong><br/>
        {{ $lead->notes ?? 'No comments provided.' }}
    </div>
    <a href="{{ url('/admin/leads') }}" class="btn">View Leads Dashboard</a>
@endsection
