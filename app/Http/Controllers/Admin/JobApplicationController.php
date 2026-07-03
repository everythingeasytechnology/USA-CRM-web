<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class JobApplicationController extends Controller
{
    public function updateStatus(Request $request, JobApplication $jobApplication): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:new,in_review,shortlisted,rejected',
        ]);

        $jobApplication->update($validated);

        return back()->with('success', 'Candidate status updated.');
    }
}
