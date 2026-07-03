<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(protected ImageUploadService $imageService)
    {
    }

    public function index(): View
    {
        $pages = Page::orderBy('id')->get();

        return view('admin.pages.index', compact('pages'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'seo_meta_title' => 'nullable|string|max:255',
            'seo_meta_desc' => 'nullable|string',
            'mock_content' => 'nullable|string',
            'hero_image' => 'nullable|image|max:4096',
        ]);

        $data = [
            'seo_title' => $validated['seo_meta_title'] ?? $page->seo_title,
            'meta_description' => $validated['seo_meta_desc'] ?? $page->meta_description,
            'content' => $validated['mock_content'] ?? $page->content,
        ];

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $this->imageService->uploadToWebp($request->file('hero_image'), 'pages');
        }

        $page->update($data);

        return back()->with('success', 'Page updated successfully.');
    }

    public function toggleActive(Page $page): RedirectResponse
    {
        $page->update(['is_active' => ! $page->is_active]);

        return back();
    }
}
