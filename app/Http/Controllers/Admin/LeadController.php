<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $query = Lead::query()->latest();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $leads = $query->get();
        $staff = User::orderBy('name')->get();

        return view('admin.leads.index', compact('leads', 'staff'));
    }

    public function update(Request $request, Lead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'status_update' => 'nullable|in:new,in_discussion,pending,completed,fake,lost',
            'assigned_staff_id' => 'nullable|exists:users,id',
        ]);

        $lead->update(array_filter([
            'status' => $validated['status_update'] ?? null,
            'assigned_staff_id' => $validated['assigned_staff_id'] ?? null,
        ], fn ($v) => $v !== null));

        return back()->with('success', 'Lead updated successfully.');
    }
}
