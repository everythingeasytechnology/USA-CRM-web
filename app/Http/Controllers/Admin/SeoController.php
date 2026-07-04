<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\NotFoundLog;
use App\Models\RedirectRule;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SeoController extends Controller
{
    public function index(Request $request): View
    {
        $redirects = RedirectRule::latest()->get();
        $notFoundLogs = NotFoundLog::orderByDesc('hit_count')->get();
        
        // Paginate locations (15 per page) to prevent memory limit exhaustion
        $locations = Location::orderBy('city')->paginate(15);
        
        // Highly performant database aggregation queries (zero model instantiation memory overhead)
        $totalCountries = Location::distinct('country')->count('country');
        $totalStates = Location::whereNotNull('state')->where('state', '!=', '')->distinct('state')->count('state');
        $totalActiveCities = Location::where('is_active', true)->count();

        return view('admin.seo.index', compact(
            'redirects', 
            'notFoundLogs', 
            'locations', 
            'totalCountries', 
            'totalStates', 
            'totalActiveCities'
        ));
    }

    public function storeRedirect(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'from_path' => 'required|string|max:255|unique:redirects,from_path',
            'to_path' => 'required|string|max:255',
            'status_code' => 'required|in:301,302',
        ]);

        RedirectRule::create($validated);
        Cache::forget('redirects.active');

        return back()->with('success', 'Redirect created.');
    }

    public function destroyRedirect(RedirectRule $redirect): RedirectResponse
    {
        $redirect->delete();
        Cache::forget('redirects.active');

        return back()->with('success', 'Redirect removed.');
    }

    public function convertLogToRedirect(NotFoundLog $log): RedirectResponse
    {
        RedirectRule::updateOrCreate(
            ['from_path' => $log->url_path],
            ['to_path' => '/', 'status_code' => 301, 'is_active' => true]
        );
        Cache::forget('redirects.active');
        $log->delete();

        return back()->with('success', 'Redirect created from 404 log entry.');
    }

    public function destroyLog(NotFoundLog $log): RedirectResponse
    {
        $log->delete();

        return back()->with('success', '404 log entry removed.');
    }

    public function storeLocation(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        Location::create($validated);

        return back()->with('success', 'Location added.');
    }

    public function destroyLocation(Location $location): RedirectResponse
    {
        $location->delete();

        return back()->with('success', 'Location removed.');
    }

    public function importLocations(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $handle = fopen($request->file('file')->getRealPath(), 'r');
        $header = fgetcsv($handle);
        $imported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);
            if (! empty($data['city']) && ! empty($data['country'])) {
                Location::create([
                    'city' => $data['city'],
                    'state' => $data['state'] ?? null,
                    'country' => $data['country'],
                ]);
                $imported++;
            }
        }
        fclose($handle);

        return back()->with('success', "{$imported} locations imported.");
    }
}
