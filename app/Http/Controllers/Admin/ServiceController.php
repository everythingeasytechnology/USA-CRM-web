<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function __construct(protected ImageUploadService $imageService)
    {
    }

    public function index(Request $request): View
    {
        $query = Service::query()->orderBy('display_order');

        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($category = $request->query('category')) {
            $query->where('category', $category);
        }

        if ($request->query('status') !== null && $request->query('status') !== '') {
            $query->where('is_active', (bool) $request->query('status'));
        }

        $services = $query->get();

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.create', ['service' => null]);
    }

    public function edit(Service $service): View
    {
        return view('admin.services.create', compact('service'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->save($request);

        return redirect('/admin/services')->with('success', 'Service created successfully.');
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $this->save($request, $service);

        return redirect('/admin/services')->with('success', 'Service updated successfully.');
    }

    protected function save(Request $request, ?Service $service = null): Service
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:services,slug,'.($service?->id ?? 'NULL').',id',
            'category' => 'required|string|max:255',
            'display_order' => 'nullable|integer',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'pseo_enabled' => 'nullable|boolean',
            'target_countries' => 'nullable|string',
            'target_states' => 'nullable|string',
            'target_cities' => 'nullable|string',
            'pseo_slug_template' => 'nullable|string',
            'pseo_title_template' => 'nullable|string',
            'pseo_desc_template' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'canonical' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'schema_custom' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'cover_image' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:4096',
        ]);

        $validated['pseo_enabled'] = $request->boolean('pseo_enabled');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $this->imageService->uploadToWebp($request->file('cover_image'), 'services');
        }

        if ($request->hasFile('gallery_images')) {
            $gallery = $service->gallery_images ?? [];
            foreach ($request->file('gallery_images') as $file) {
                $path = $this->imageService->uploadToWebp($file, 'services/gallery');
                if ($path) {
                    $gallery[] = $path;
                }
            }
            $validated['gallery_images'] = $gallery;
        }

        if ($service) {
            $service->update($validated);

            return $service;
        }

        return Service::create($validated);
    }

    public function duplicate(Service $service): RedirectResponse
    {
        $clone = $service->replicate();
        $clone->name = $service->name.' (Copy)';
        $clone->slug = $service->slug.'-copy-'.time();
        $clone->is_active = false;
        $clone->save();

        return redirect('/admin/services')->with('success', 'Service duplicated successfully.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect('/admin/services')->with('success', 'Service deleted successfully.');
    }

    public function exportUrls(Service $service)
    {
        $baseUrl = url('/');
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $service->slug . '-location-urls.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($service, $baseUrl) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Target City', 'Target State', 'Target Country', 'Programmatic SEO URL']);
            
            // Base URL
            fputcsv($file, ['Global / Base', 'All States', 'United States / India', $baseUrl . '/services/' . $service->slug]);

            // Location URLs
            $locations = \App\Models\Location::orderBy('city')->get();
            foreach ($locations as $loc) {
                $citySlug = \Illuminate\Support\Str::slug($loc->city);
                $pseoUrl = $baseUrl . '/services/' . $service->slug . '-in-' . $citySlug;
                fputcsv($file, [$loc->city, $loc->state ?? 'N/A', $loc->country, $pseoUrl]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function toggleActive(Service $service): RedirectResponse
    {
        $service->update(['is_active' => !$service->is_active]);

        return back()->with('success', 'Service status updated successfully.');
    }
}
