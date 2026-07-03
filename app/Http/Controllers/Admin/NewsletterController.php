<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NewsletterController extends Controller
{
    public function index(): View
    {
        $subs = NewsletterSubscriber::latest()->get();

        return view('admin.newsletter', compact('subs'));
    }

    public function toggleStatus(NewsletterSubscriber $newsletter): RedirectResponse
    {
        $newsletter->update(['status' => ! $newsletter->status]);

        return back();
    }
}
