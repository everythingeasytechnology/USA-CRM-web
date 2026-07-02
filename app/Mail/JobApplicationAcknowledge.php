<?php

namespace App\Mail;

use App\Models\JobApplication;
use App\Models\JobPosting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobApplicationAcknowledge extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $job;

    public function __construct(JobApplication $application, JobPosting $job)
    {
        $this->application = $application;
        $this->job = $job;
    }

    public function build()
    {
        return $this->subject('Thank you for applying: ' . $this->job->title)
                    ->view('emails.job_application');
    }
}
