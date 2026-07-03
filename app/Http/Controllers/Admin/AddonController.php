<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AddonController extends Controller
{
    public function index(): View
    {
        $addons = Addon::orderBy('sort_order')->get();

        return view('admin.addons', compact('addons'));
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $validated['is_active'] = $request->boolean('is_active');

        Addon::create($validated);

        return redirect('/admin/addons')->with('success', 'Add-on created successfully.');
    }

    public function update(Request $request, Addon $addon): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $validated['is_active'] = $request->boolean('is_active');

        $addon->update($validated);

        return redirect('/admin/addons')->with('success', 'Add-on updated successfully.');
    }

    public function destroy(Addon $addon): RedirectResponse
    {
        $addon->delete();

        return redirect('/admin/addons')->with('success', 'Add-on deleted successfully.');
    }

    public function toggleActive(Addon $addon): RedirectResponse
    {
        $addon->update(['is_active' => ! $addon->is_active]);

        return back();
    }
}
