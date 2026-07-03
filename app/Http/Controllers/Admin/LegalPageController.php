<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalPage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LegalPageController extends Controller
{
    public function index(): View
    {
        $legalPages = LegalPage::orderBy('id')->get()->keyBy('slug');

        return view('admin.legal', compact('legalPages'));
    }

    public function update(Request $request, LegalPage $legalPage): RedirectResponse
    {
        $validated = $request->validate([
            'legal_title' => 'required|string|max:255',
            'legal_version' => 'nullable|string|max:100',
            'legal_updated' => 'nullable|date',
            'legal_author' => 'nullable|string|max:100',
            'legal_body' => 'required|string',
            'legal_seo_title' => 'nullable|string|max:255',
            'legal_canonical' => 'nullable|string|max:255',
            'legal_meta_desc' => 'nullable|string',
            'legal_noindex' => 'nullable|boolean',
        ]);

        $legalPage->update([
            'title' => $validated['legal_title'],
            'version' => $validated['legal_version'] ?? null,
            'effective_date' => $validated['legal_updated'] ?? null,
            'author_role' => $validated['legal_author'] ?? null,
            'content' => $validated['legal_body'],
            'seo_title' => $validated['legal_seo_title'] ?? null,
            'canonical' => $validated['legal_canonical'] ?? null,
            'meta_description' => $validated['legal_meta_desc'] ?? null,
            'noindex' => $request->boolean('legal_noindex'),
        ]);

        return back()->with('success', 'Legal document updated successfully.');
    }
}
