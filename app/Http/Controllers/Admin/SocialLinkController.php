<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SocialLinkController extends Controller
{
    public function index(): View
    {
        $platforms = SocialLink::orderBy('sort_order')->get();

        return view('admin.social', compact('platforms'));
    }

    public function update(Request $request): RedirectResponse
    {
        foreach (SocialLink::all() as $platform) {
            $platform->update([
                'is_enabled' => $request->boolean("social_{$platform->platform}_enabled"),
                'url' => $request->input("social_{$platform->platform}_url"),
            ]);
        }

        return back()->with('success', 'Social links saved.');
    }
}
