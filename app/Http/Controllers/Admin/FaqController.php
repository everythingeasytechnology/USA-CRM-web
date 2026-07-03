<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $faqs = Faq::orderBy('sort_order')->get();

        return view('admin.faqs', compact('faqs'));
    }

    protected function rules(): array
    {
        return [
            'faq_question' => 'required|string|max:255',
            'faq_cat' => 'required|in:general,pricing,technical',
            'faq_answer' => 'required|string',
            'faq_visible' => 'nullable|boolean',
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        Faq::create([
            'question' => $validated['faq_question'],
            'category' => $validated['faq_cat'],
            'answer' => $validated['faq_answer'],
            'is_active' => $request->boolean('faq_visible'),
        ]);

        return redirect('/admin/faqs')->with('success', 'FAQ created.');
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $faq->update([
            'question' => $validated['faq_question'],
            'category' => $validated['faq_cat'],
            'answer' => $validated['faq_answer'],
            'is_active' => $request->boolean('faq_visible'),
        ]);

        return redirect('/admin/faqs')->with('success', 'FAQ updated.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect('/admin/faqs')->with('success', 'FAQ deleted.');
    }

    public function toggleActive(Faq $faq): RedirectResponse
    {
        $faq->update(['is_active' => ! $faq->is_active]);

        return back();
    }
}
