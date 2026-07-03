<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function __construct(protected ImageUploadService $imageService)
    {
    }

    public function index(): View
    {
        $files = Media::latest()->get();

        return view('admin.media', compact('files'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $upload = $request->file('file');
        $mime = $upload->getMimeType();

        if (str_starts_with($mime, 'image/')) {
            $path = $this->imageService->uploadToWebp($upload, 'media');
        } else {
            $filename = Str::uuid().'.'.$upload->getClientOriginalExtension();
            $path = 'storage/'.$upload->storeAs('media', $filename, 'public');
        }

        Media::create([
            'name' => $upload->getClientOriginalName(),
            'mime_type' => $mime,
            'disk_path' => $path,
            'url' => asset($path),
            'alt_text' => $request->input('alt_text'),
            'size' => $upload->getSize(),
        ]);

        return back()->with('success', 'File uploaded successfully.');
    }

    public function update(Request $request, Media $media): RedirectResponse
    {
        $validated = $request->validate([
            'alt_text' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
        ]);

        $media->update($validated);

        return back()->with('success', 'Media metadata updated.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        Storage::disk('public')->delete(str_replace('storage/', '', $media->disk_path));
        $media->delete();

        return back()->with('success', 'File deleted successfully.');
    }
}
