<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    protected array $keys = [
        'company_name', 'brand_name', 'tagline', 'website_url', 'copyright',
        'support_email', 'sales_email', 'phone', 'whatsapp', 'address', 'gmaps',
        'ga_id', 'gtm_id', 'meta_pixel', 'gsc_verification', 'bing_verification',
        'yandex_verification', 'indexnow_key', 'header_scripts', 'footer_scripts',
        'theme_primary', 'theme_secondary', 'maintenance_mode',
        'smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_encryption',
    ];

    public function index(): View
    {
        $settings = [];
        foreach ($this->keys as $key) {
            $settings[$key] = Setting::get($key);
        }

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        foreach ($this->keys as $key) {
            if ($key === 'maintenance_mode') {
                Setting::set($key, $request->boolean($key) ? '1' : '0', 'site');
                continue;
            }
            if ($request->has($key)) {
                Setting::set($key, $request->input($key), 'site');
            }
        }

        return back()->with('success', 'Settings saved.');
    }
}
