<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Lead;
use App\Models\JobPosting;
use App\Models\JobApplication;
use App\Models\Order;
use App\Mail\ContactSubmissionAlert;
use App\Mail\ContactAutoReply;
use App\Mail\LeadEnquiryAlert;
use App\Mail\LeadConfirmation;
use App\Mail\OrderConfirmation;
use App\Mail\JobApplicationAcknowledge;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FormSubmissionController extends Controller
{
    protected $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Handle public contact form submissions.
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        try {
            DB::beginTransaction();

            $validated['ip_address'] = $request->ip();
            $message = ContactMessage::create($validated);

            // Trigger Emails
            Mail::to(config('mail.from.address', 'admin@everythingeasy.in'))->send(new ContactSubmissionAlert($validated));
            Mail::to($validated['email'])->send(new ContactAutoReply($validated));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully!',
                'data' => $message
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Contact form submission failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Unable to send message. Please try again later.'
            ], 500);
        }
    }

    /**
     * Handle project lead/quote inquiries.
     */
    public function submitLead(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'service_requested' => 'required|string|max:255',
            'budget' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'source' => 'required|string|max:100',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $validated['status'] = 'new';
            $lead = Lead::create($validated);

            // Trigger Emails
            Mail::to(config('mail.from.address', 'sales@everythingeasy.in'))->send(new LeadEnquiryAlert($lead));
            Mail::to($validated['email'])->send(new LeadConfirmation($lead));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Your lead request has been captured!',
                'data' => $lead
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Lead submission failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Submission failed. Please check parameters.'
            ], 500);
        }
    }

    /**
     * Handle job applications with resume uploads.
     */
    public function submitApplication(Request $request)
    {
        $validated = $request->validate([
            'job_posting_id' => 'required|exists:job_postings,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'experience' => 'required|string|max:50',
            'portfolio_url' => 'nullable|url|max:255',
            'resume' => 'required|file|mimes:pdf|max:5120', // Max 5MB PDF
            'cover_letter' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Store PDF Resume file safely
            if ($request->hasFile('resume')) {
                $resumeFile = $request->file('resume');
                $filename = Str::uuid() . '.pdf';
                $resumePath = $resumeFile->storeAs('resumes', $filename, 'public');
                $validated['resume_path'] = 'storage/' . $resumePath;
            }

            $validated['status'] = 'new';
            $application = JobApplication::create($validated);
            $job = JobPosting::find($validated['job_posting_id']);

            // Trigger Email ONLY to Candidate, NOT Admin
            Mail::to($validated['email'])->send(new JobApplicationAcknowledge($application, $job));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Your application has been received successfully!',
                'data' => $application
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Job application submission failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Application processing error.'
            ], 500);
        }
    }

    /**
     * Handle order payment confirmations.
     */
    public function submitOrder(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'service_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'billing_address' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $validated['order_number'] = 'INV-' . strtoupper(Str::random(10));
            $validated['status'] = 'paid'; // Seeded as paid for immediate invoice trigger
            
            $order = Order::create($validated);

            // Trigger Emails (Both Admin and Customer get Order invoice alert)
            Mail::to(config('mail.from.address', 'finance@everythingeasy.in'))->send(new OrderConfirmation($order));
            Mail::to($validated['email'])->send(new OrderConfirmation($order));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully and invoice sent!',
                'data' => $order
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Order processing failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Invoicing processing failure.'
            ], 500);
        }
    }
}
