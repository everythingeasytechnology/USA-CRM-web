<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();

        return view('admin.testimonials', compact('testimonials'));
    }

    protected function rules(): array
    {
        return [
            'client_name' => 'required|string|max:255',
            'client_company' => 'nullable|string|max:255',
            'client_rating' => 'required|integer|min:1|max:5',
            'client_review' => 'required|string',
            'client_status_active' => 'nullable|boolean',
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        Testimonial::create([
            'name' => $validated['client_name'],
            'company' => $validated['client_company'] ?? null,
            'rating' => $validated['client_rating'],
            'review' => $validated['client_review'],
            'is_active' => $request->boolean('client_status_active'),
        ]);

        return redirect('/admin/testimonials')->with('success', 'Testimonial added.');
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $testimonial->update([
            'name' => $validated['client_name'],
            'company' => $validated['client_company'] ?? null,
            'rating' => $validated['client_rating'],
            'review' => $validated['client_review'],
            'is_active' => $request->boolean('client_status_active'),
        ]);

        return redirect('/admin/testimonials')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect('/admin/testimonials')->with('success', 'Testimonial deleted.');
    }

    public function toggleActive(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update(['is_active' => ! $testimonial->is_active]);

        return back();
    }
}
