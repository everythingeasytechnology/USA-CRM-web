@extends('emails.layout')
@section('content')
    <h2>Application Received, {{ $application->name }}!</h2>
    <p>Thank you for applying for the position of <strong>{{ $job->title }}</strong> at EverythingEasy.</p>
    <p>Our Human Resources team has successfully received your profile details, resume, and cover letter statement. We are reviewing matching skills sets and experience timelines.</p>
    <p>If your background matches our requirements, we will reach out to you within the next 5 business days to schedule a technical interview round.</p>
    <div class="highlight-box">
        <strong>Application Specs:</strong><br/>
        - Job Opening: {{ $job->title }} ({{ $job->location }})<br/>
        - Declared Experience: {{ $application->experience }}
    </div>
    <p>Best Regards,<br/><strong>Recruitment Team | EverythingEasy Agency</strong></p>
@endsection
