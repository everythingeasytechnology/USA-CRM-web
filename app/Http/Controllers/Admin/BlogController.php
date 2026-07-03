<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function __construct(protected ImageUploadService $imageService)
    {
    }

    public function index(): View
    {
        $blogs = Blog::latest()->get();

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create(): View
    {
        return view('admin.blogs.create', ['blog' => null]);
    }

    public function edit(Blog $blog): View
    {
        return view('admin.blogs.create', compact('blog'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->save($request);

        return redirect('/admin/blogs')->with('success', 'Article published successfully.');
    }

    public function update(Request $request, Blog $blog): RedirectResponse
    {
        $this->save($request, $blog);

        return redirect('/admin/blogs')->with('success', 'Article updated successfully.');
    }

    protected function save(Request $request, ?Blog $blog = null): Blog
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug,'.($blog?->id ?? 'NULL').',id',
            'category_id' => 'nullable|string|max:255',
            'body' => 'required|string',
            'read_time' => 'nullable|string|max:50',
            'seo_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'article_schema' => 'nullable|string',
            'status' => 'nullable|boolean',
            'cover_image' => 'nullable|image|max:4096',
        ]);

        $categories = ['1' => 'Web Development', '2' => 'SEO Insights', '3' => 'Digital Growth'];

        $data = [
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content' => $validated['body'],
            'category' => $categories[$validated['category_id'] ?? ''] ?? ($validated['category_id'] ?? null),
            'read_time' => $validated['read_time'] ?? null,
            'seo_title' => $validated['seo_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'schema_custom' => $validated['article_schema'] ?? null,
            'is_published' => $request->boolean('status'),
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->imageService->uploadToWebp($request->file('cover_image'), 'blogs');
        }

        if ($blog) {
            $blog->update($data);

            return $blog;
        }

        return Blog::create($data);
    }

    public function duplicate(Blog $blog): RedirectResponse
    {
        $clone = $blog->replicate();
        $clone->title = $blog->title.' (Copy)';
        $clone->slug = $blog->slug.'-copy-'.time();
        $clone->is_published = false;
        $clone->save();

        return redirect('/admin/blogs')->with('success', 'Article duplicated successfully.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        $blog->delete();

        return redirect('/admin/blogs')->with('success', 'Article deleted successfully.');
    }

    public function toggleActive(Blog $blog): RedirectResponse
    {
        $blog->update(['is_published' => ! $blog->is_published]);

        return back();
    }
}
