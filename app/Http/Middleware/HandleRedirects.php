<?php

namespace App\Http\Middleware;

use App\Models\RedirectRule;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class HandleRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        $path = '/'.ltrim($request->path(), '/');

        $rules = Cache::rememberForever('redirects.active', function () {
            return RedirectRule::query()->where('is_active', true)->get(['from_path', 'to_path', 'status_code'])
                ->map(fn ($r) => ['to_path' => $r->to_path, 'status_code' => $r->status_code])
                ->keyBy('from_path')
                ->toArray();
        });

        if (isset($rules[$path])) {
            return redirect($rules[$path]['to_path'], $rules[$path]['status_code']);
        }

        return $next($request);
    }
}
