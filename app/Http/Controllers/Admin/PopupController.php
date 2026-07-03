<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PopupController extends Controller
{
    public function index(): View
    {
        $popups = Popup::latest()->get();

        return view('admin.popups', compact('popups'));
    }

    protected function rules(): array
    {
        return [
            'pop_title' => 'required|string|max:255',
            'pop_trigger' => 'required|in:exit,delay,scroll',
            'pop_start' => 'nullable|date',
            'pop_end' => 'nullable|date',
            'pop_html' => 'nullable|string',
            'pop_enabled_active' => 'nullable|boolean',
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        Popup::create([
            'title' => $validated['pop_title'],
            'trigger_type' => $validated['pop_trigger'],
            'starts_at' => $validated['pop_start'] ?? null,
            'ends_at' => $validated['pop_end'] ?? null,
            'content' => $validated['pop_html'] ?? null,
            'is_active' => $request->boolean('pop_enabled_active'),
        ]);

        return redirect('/admin/popups')->with('success', 'Popup created.');
    }

    public function update(Request $request, Popup $popup): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $popup->update([
            'title' => $validated['pop_title'],
            'trigger_type' => $validated['pop_trigger'],
            'starts_at' => $validated['pop_start'] ?? null,
            'ends_at' => $validated['pop_end'] ?? null,
            'content' => $validated['pop_html'] ?? null,
            'is_active' => $request->boolean('pop_enabled_active'),
        ]);

        return redirect('/admin/popups')->with('success', 'Popup updated.');
    }

    public function destroy(Popup $popup): RedirectResponse
    {
        $popup->delete();

        return redirect('/admin/popups')->with('success', 'Popup deleted.');
    }

    public function toggleActive(Popup $popup): RedirectResponse
    {
        $popup->update(['is_active' => ! $popup->is_active]);

        return back();
    }
}
