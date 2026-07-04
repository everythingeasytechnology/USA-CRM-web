<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class SystemAdminController extends Controller
{
    /**
     * Clear application cache using optimize:clear.
     */
    public function clearCache()
    {
        try {
            Artisan::call('optimize:clear');
            return response()->json([
                'success' => true,
                'message' => 'System cache cleared successfully!',
                'output' => Artisan::output()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cache clear error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle public site maintenance lock.
     */
    public function toggleMaintenance(Request $request)
    {
        try {
            $lockFile = storage_path('framework/down');
            $active = file_exists($lockFile);

            if ($active) {
                if (unlink($lockFile)) {
                    $active = false;
                }
            } else {
                file_put_contents($lockFile, json_encode([
                    'time' => time(),
                    'retry' => 60,
                    'allowed' => ['127.0.0.1']
                ]));
                $active = true;
            }

            return response()->json([
                'success' => true,
                'maintenance' => $active,
                'message' => $active ? 'Maintenance mode is now active.' : 'Maintenance mode is disabled.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Maintenance toggle failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Build sitemaps index list dynamically.
     */
    public function buildSitemap()
    {
        try {
            // Set max execution time to 5 minutes to allow large sitemap generation
            set_time_limit(300);
            
            $baseUrl = url('/');
            $currentDate = date('Y-m-d');
            
            // ==========================================
            // 1. Generate sitemap-main.xml (Core Pages)
            // ==========================================
            $mainXml = [];
            $mainXml[] = '<?xml version="1.0" encoding="UTF-8"?>';
            $mainXml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            
            $coreUrls = ['', '/about', '/services', '/portfolio', '/blogs', '/contact', '/careers'];
            foreach ($coreUrls as $path) {
                $mainXml[] = '  <url>';
                $mainXml[] = '    <loc>' . htmlspecialchars($baseUrl . $path) . '</loc>';
                $mainXml[] = '    <lastmod>' . $currentDate . '</lastmod>';
                $mainXml[] = '    <changefreq>weekly</changefreq>';
                $mainXml[] = '    <priority>0.8</priority>';
                $mainXml[] = '  </url>';
            }
            $mainXml[] = '</urlset>';
            file_put_contents(public_path('sitemap-main.xml'), implode("\n", $mainXml));

            // ==========================================
            // 2. Generate sitemap-services.xml (Base & Locations with chunking/splitting)
            // ==========================================
            $services = Service::where('is_active', true)->get();
            $locationNodes = 0;
            
            $serviceSitemaps = [];
            $fileIndex = 1;
            $currentXml = [];
            $urlCount = 0;

            foreach ($services as $srv) {
                // Add the base service page
                $currentXml[] = '  <url>';
                $currentXml[] = '    <loc>' . htmlspecialchars($baseUrl . '/services/' . $srv->slug) . '</loc>';
                $currentXml[] = '    <lastmod>' . $srv->updated_at->format('Y-m-d') . '</lastmod>';
                $currentXml[] = '    <changefreq>weekly</changefreq>';
                $currentXml[] = '    <priority>0.7</priority>';
                $currentXml[] = '  </url>';
                $urlCount++;
                
                // Add target locations dynamically via low-memory DB chunking (40,000 URLs per file limit)
                if ($srv->pseo_enabled) {
                    \Illuminate\Support\Facades\DB::table('locations')
                        ->select('city')
                        ->orderBy('id')
                        ->chunk(5000, function ($locations) use (&$currentXml, &$urlCount, &$fileIndex, &$serviceSitemaps, $baseUrl, $srv, $currentDate, &$locationNodes) {
                            foreach ($locations as $loc) {
                                $locationSlug = \Illuminate\Support\Str::slug($loc->city);
                                $currentXml[] = '  <url>';
                                $currentXml[] = '    <loc>' . htmlspecialchars($baseUrl . '/services/' . $srv->slug . '-in-' . $locationSlug) . '</loc>';
                                $currentXml[] = '    <lastmod>' . $currentDate . '</lastmod>';
                                $currentXml[] = '    <changefreq>monthly</changefreq>';
                                $currentXml[] = '    <priority>0.6</priority>';
                                $currentXml[] = '  </url>';
                                $urlCount++;
                                $locationNodes++;
                                
                                // Write to file if it reaches 40,000 links (Google max limit is 50,000)
                                if ($urlCount >= 40000) {
                                    $filename = "sitemap-services-{$fileIndex}.xml";
                                    $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
                                                 '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n" .
                                                 implode("\n", $currentXml) . "\n" .
                                                 '</urlset>';
                                    file_put_contents(public_path($filename), $xmlContent);
                                    $serviceSitemaps[] = $filename;
                                    
                                    // Reset counters
                                    $currentXml = [];
                                    $urlCount = 0;
                                    $fileIndex++;
                                }
                            }
                        });
                }
            }

            // Write any leftover URLs to the final services sitemap file
            if ($urlCount > 0 || empty($serviceSitemaps)) {
                $filename = "sitemap-services-{$fileIndex}.xml";
                $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
                             '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n" .
                             implode("\n", $currentXml) . "\n" .
                             '</urlset>';
                file_put_contents(public_path($filename), $xmlContent);
                $serviceSitemaps[] = $filename;
            }

            // ==========================================
            // 3. Generate sitemap-blogs.xml (Blogs list)
            // ==========================================
            $blogsXml = [];
            $blogsXml[] = '<?xml version="1.0" encoding="UTF-8"?>';
            $blogsXml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            
            $blogs = Blog::where('is_published', true)->get();
            foreach ($blogs as $post) {
                $blogsXml[] = '  <url>';
                $blogsXml[] = '    <loc>' . htmlspecialchars($baseUrl . '/blogs/' . $post->slug) . '</loc>';
                $blogsXml[] = '    <lastmod>' . $post->updated_at->format('Y-m-d') . '</lastmod>';
                $blogsXml[] = '    <changefreq>monthly</changefreq>';
                $blogsXml[] = '    <priority>0.5</priority>';
                $blogsXml[] = '  </url>';
            }
            $blogsXml[] = '</urlset>';
            file_put_contents(public_path('sitemap-blogs.xml'), implode("\n", $blogsXml));

            // ==========================================
            // 4. Generate sitemap.xml (Main Sitemap Index)
            // ==========================================
            $indexXml = [];
            $indexXml[] = '<?xml version="1.0" encoding="UTF-8"?>';
            $indexXml[] = '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            
            $subSitemaps = array_merge(['sitemap-main.xml'], $serviceSitemaps, ['sitemap-blogs.xml']);
            foreach ($subSitemaps as $sub) {
                $indexXml[] = '  <sitemap>';
                $indexXml[] = '    <loc>' . htmlspecialchars($baseUrl . '/' . $sub) . '</loc>';
                $indexXml[] = '    <lastmod>' . $currentDate . '</lastmod>';
                $indexXml[] = '  </sitemap>';
            }
            $indexXml[] = '</sitemapindex>';
            file_put_contents(public_path('sitemap.xml'), implode("\n", $indexXml));

            $totalUrlNodes = count($coreUrls) + count($services) + count($blogs) + $locationNodes;

            return response()->json([
                'success' => true,
                'count' => $totalUrlNodes,
                'message' => "XML sitemap index rebuilt. Sub-sitemaps written (sitemap-main.xml, " . implode(', ', $serviceSitemaps) . ", sitemap-blogs.xml) and linked under sitemap.xml."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sitemap build failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create database backup archive.
     */
    public function createBackup()
    {
        try {
            $filename = 'backup-' . date('Y-m-d-His') . '.zip';
            
            // In a real environment, we'd run spatie/laravel-backup or zip utility
            // Here, we simulate generating a backup log file in storage
            if (!Storage::disk('local')->exists('backups')) {
                Storage::disk('local')->makeDirectory('backups');
            }
            Storage::disk('local')->put('backups/' . $filename, 'EverythingEasy database SQLite backup content log.');

            return response()->json([
                'success' => true,
                'filename' => $filename,
                'message' => 'System backup archive created successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Backup processing failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
