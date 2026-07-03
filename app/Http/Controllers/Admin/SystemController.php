<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class SystemController extends Controller
{
    public function index(): View
    {
        $logPath = storage_path('logs/laravel.log');
        $logTail = '';

        if (file_exists($logPath)) {
            $lines = array_slice(file($logPath), -30);
            $logTail = implode('', $lines);
        }

        return view('admin.system', [
            'phpVersion' => phpversion(),
            'laravelVersion' => app()->version(),
            'uploadLimit' => ini_get('upload_max_filesize'),
            'timezone' => config('app.timezone'),
            'logTail' => $logTail,
        ]);
    }

    public function clearCache(string $type): RedirectResponse
    {
        $commands = [
            'route' => 'route:clear',
            'view' => 'view:clear',
            'config' => 'config:clear',
        ];

        if (isset($commands[$type])) {
            Artisan::call($commands[$type]);
        }

        return back()->with('success', ucfirst($type).' cache cleared.');
    }
}
