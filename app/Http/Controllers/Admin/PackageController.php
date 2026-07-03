<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index(): View
    {
        $packages = Package::with('service')->orderBy('display_order')->get();

        return view('admin.packages.index', compact('packages'));
    }

    public function create(): View
    {
        $services = Service::orderBy('name')->get();

        return view('admin.packages.create', ['package' => null, 'services' => $services]);
    }

    public function edit(Package $package): View
    {
        $services = Service::orderBy('name')->get();

        return view('admin.packages.create', compact('package', 'services'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->save($request);

        return redirect('/admin/packages')->with('success', 'Package created successfully.');
    }

    public function update(Request $request, Package $package): RedirectResponse
    {
        $this->save($request, $package);

        return redirect('/admin/packages')->with('success', 'Package updated successfully.');
    }

    protected function save(Request $request, ?Package $package = null): Package
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'service_id' => 'required|exists:services,id',
            'badge' => 'nullable|string|max:100',
            'short_desc' => 'required|string',
            'full_desc' => 'nullable|string',
            'price_starting' => 'required|numeric|min:0',
            'price_original' => 'nullable|numeric|min:0',
            'price_discount' => 'nullable|numeric|min:0',
            'delivery_time' => 'required|string|max:100',
            'revisions' => 'nullable|string|max:50',
            'support_duration' => 'nullable|string|max:100',
            'tech_stack' => 'nullable|string|max:255',
            'suitable_for' => 'nullable|string|max:255',
            'features' => 'required|string',
            'cta_url' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?: Str::slug($validated['name']),
            'service_id' => $validated['service_id'],
            'badge' => $validated['badge'] ?? null,
            'description' => $validated['short_desc'] ?: ($validated['full_desc'] ?? ''),
            'price' => $validated['price_starting'],
            'original_price' => $validated['price_original'] ?? null,
            'discount_price' => $validated['price_discount'] ?? null,
            'delivery_time' => $validated['delivery_time'],
            'revisions' => $validated['revisions'] ?? null,
            'support_duration' => $validated['support_duration'] ?? null,
            'tech_stack' => $validated['tech_stack'] ?? null,
            'suitable_for' => $validated['suitable_for'] ?? null,
            'features' => array_values(array_filter(array_map('trim', explode("\n", $validated['features'])))),
            'cta_url' => $validated['cta_url'] ?? null,
            'display_order' => $validated['display_order'] ?? 0,
            'status' => $request->boolean('status'),
            'is_featured' => $request->boolean('is_featured'),
        ];

        if ($package) {
            $package->update($data);

            return $package;
        }

        return Package::create($data);
    }

    public function duplicate(Package $package): RedirectResponse
    {
        $clone = $package->replicate();
        $clone->name = $package->name.' (Copy)';
        $clone->slug = $package->slug.'-copy-'.time();
        $clone->status = false;
        $clone->save();

        return redirect('/admin/packages')->with('success', 'Package duplicated successfully.');
    }

    public function destroy(Package $package): RedirectResponse
    {
        $package->delete();

        return redirect('/admin/packages')->with('success', 'Package deleted successfully.');
    }

    public function toggleActive(Package $package): RedirectResponse
    {
        $package->update(['status' => ! $package->status]);

        return back();
    }
}
