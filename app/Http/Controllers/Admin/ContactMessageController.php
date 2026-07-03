<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = ContactMessage::query()->latest();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($formType = $request->query('form_type')) {
            $query->where('form_type', $formType);
        }

        $msgs = $query->get();

        $recaptcha = [
            'enabled' => Setting::get('recaptcha_enabled', false),
            'site' => Setting::get('recaptcha_site', ''),
            'secret' => Setting::get('recaptcha_secret', ''),
            'threshold' => Setting::get('score_threshold', '0.5'),
        ];

        return view('admin.forms', compact('msgs', 'recaptcha'));
    }

    public function updateRecaptcha(Request $request): RedirectResponse
    {
        Setting::setMany([
            'recaptcha_enabled' => $request->boolean('recaptcha_enabled') ? '1' : '0',
            'recaptcha_site' => $request->input('recaptcha_site'),
            'recaptcha_secret' => $request->input('recaptcha_secret'),
            'score_threshold' => $request->input('score_threshold'),
        ], 'recaptcha');

        return back()->with('success', 'Spam controls updated.');
    }
}
