<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JobPostingController extends Controller
{
    public function index(): View
    {
        $jobs = JobPosting::all();
        $candidates = JobApplication::with('jobPosting')->latest()->get();

        return view('admin.careers', compact('jobs', 'candidates'));
    }

    protected function rules(): array
    {
        return [
            'job_title' => 'required|string|max:255',
            'job_location' => 'required|string|max:255',
            'job_desc' => 'required|string',
            'job_reqs' => 'required|string',
            'job_published' => 'nullable|boolean',
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        JobPosting::create([
            'title' => $validated['job_title'],
            'location' => $validated['job_location'],
            'description' => $validated['job_desc'],
            'requirements' => array_values(array_filter(array_map('trim', explode("\n", $validated['job_reqs'])))),
            'status' => $request->boolean('job_published'),
        ]);

        return redirect('/admin/careers')->with('success', 'Job posting created.');
    }

    public function update(Request $request, JobPosting $jobPosting): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $jobPosting->update([
            'title' => $validated['job_title'],
            'location' => $validated['job_location'],
            'description' => $validated['job_desc'],
            'requirements' => array_values(array_filter(array_map('trim', explode("\n", $validated['job_reqs'])))),
            'status' => $request->boolean('job_published'),
        ]);

        return redirect('/admin/careers')->with('success', 'Job posting updated.');
    }

    public function destroy(JobPosting $jobPosting): RedirectResponse
    {
        $jobPosting->delete();

        return redirect('/admin/careers')->with('success', 'Job posting deleted.');
    }

    public function toggleActive(JobPosting $jobPosting): RedirectResponse
    {
        $jobPosting->update(['status' => ! $jobPosting->status]);

        return back();
    }
}
