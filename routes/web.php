<?php

use App\Http\Controllers\Admin\AddonController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\JobApplicationController;
use App\Http\Controllers\Admin\JobPostingController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\LegalPageController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\PopupController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Models\NotFoundLog;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

// Admin auth
Route::get('/admin/login', [AuthController::class, 'showLogin'])->middleware('guest')->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/admin/logout', [AuthController::class, 'logout'])->middleware('auth');

// Admin Route Group
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });

    // Website Settings
    Route::get('/settings', [SettingController::class, 'index']);
    Route::put('/settings', [SettingController::class, 'update']);

    // Social Links
    Route::get('/social', [SocialLinkController::class, 'index']);
    Route::put('/social', [SocialLinkController::class, 'update']);

    // Services
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/create', [ServiceController::class, 'create']);
    Route::post('/services', [ServiceController::class, 'store']);
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit']);
    Route::put('/services/{service}', [ServiceController::class, 'update']);
    Route::delete('/services/{service}', [ServiceController::class, 'destroy']);
    Route::post('/services/{service}/duplicate', [ServiceController::class, 'duplicate']);
    Route::patch('/services/{service}/toggle-active', [ServiceController::class, 'toggleActive']);

    // Packages
    Route::get('/packages', [PackageController::class, 'index']);
    Route::get('/packages/create', [PackageController::class, 'create']);
    Route::post('/packages', [PackageController::class, 'store']);
    Route::get('/packages/{package}/edit', [PackageController::class, 'edit']);
    Route::put('/packages/{package}', [PackageController::class, 'update']);
    Route::delete('/packages/{package}', [PackageController::class, 'destroy']);
    Route::post('/packages/{package}/duplicate', [PackageController::class, 'duplicate']);
    Route::patch('/packages/{package}/toggle-active', [PackageController::class, 'toggleActive']);

    // Addons
    Route::get('/addons', [AddonController::class, 'index']);
    Route::post('/addons', [AddonController::class, 'store']);
    Route::put('/addons/{addon}', [AddonController::class, 'update']);
    Route::delete('/addons/{addon}', [AddonController::class, 'destroy']);
    Route::patch('/addons/{addon}/toggle-active', [AddonController::class, 'toggleActive']);

    // Orders
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus']);

    // Payment Gateways
    Route::get('/payment', [PaymentGatewayController::class, 'index']);
    Route::put('/payment', [PaymentGatewayController::class, 'update']);

    // Blogs
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blogs/create', [BlogController::class, 'create']);
    Route::post('/blogs', [BlogController::class, 'store']);
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit']);
    Route::put('/blogs/{blog}', [BlogController::class, 'update']);
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy']);
    Route::post('/blogs/{blog}/duplicate', [BlogController::class, 'duplicate']);
    Route::patch('/blogs/{blog}/toggle-active', [BlogController::class, 'toggleActive']);

    // Media Library
    Route::get('/media', [MediaController::class, 'index']);
    Route::post('/media', [MediaController::class, 'store']);
    Route::put('/media/{media}', [MediaController::class, 'update']);
    Route::delete('/media/{media}', [MediaController::class, 'destroy']);

    // Leads
    Route::get('/leads', [LeadController::class, 'index']);
    Route::patch('/leads/{lead}', [LeadController::class, 'update']);

    // Forms / Enquiries
    Route::get('/forms', [ContactMessageController::class, 'index']);
    Route::post('/forms/recaptcha', [ContactMessageController::class, 'updateRecaptcha']);

    // Static Pages
    Route::get('/pages', [PageController::class, 'index']);
    Route::put('/pages/{page}', [PageController::class, 'update']);
    Route::patch('/pages/{page}/toggle-active', [PageController::class, 'toggleActive']);

    // Legal Pages
    Route::get('/legal', [LegalPageController::class, 'index']);
    Route::put('/legal/{legalPage}', [LegalPageController::class, 'update']);

    // SEO: redirects, 404 monitor, locations
    Route::get('/seo', [SeoController::class, 'index']);
    Route::post('/seo/redirects', [SeoController::class, 'storeRedirect']);
    Route::delete('/seo/redirects/{redirect}', [SeoController::class, 'destroyRedirect']);
    Route::post('/seo/404-logs/{log}/convert', [SeoController::class, 'convertLogToRedirect']);
    Route::delete('/seo/404-logs/{log}', [SeoController::class, 'destroyLog']);
    Route::post('/seo/locations', [SeoController::class, 'storeLocation']);
    Route::delete('/seo/locations/{location}', [SeoController::class, 'destroyLocation']);
    Route::post('/seo/locations/import', [SeoController::class, 'importLocations']);

    // Testimonials
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::post('/testimonials', [TestimonialController::class, 'store']);
    Route::put('/testimonials/{testimonial}', [TestimonialController::class, 'update']);
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy']);
    Route::patch('/testimonials/{testimonial}/toggle-active', [TestimonialController::class, 'toggleActive']);

    // Team Members
    Route::get('/team', [TeamMemberController::class, 'index']);
    Route::post('/team', [TeamMemberController::class, 'store']);
    Route::put('/team/{team}', [TeamMemberController::class, 'update']);
    Route::delete('/team/{team}', [TeamMemberController::class, 'destroy']);

    // FAQs
    Route::get('/faqs', [FaqController::class, 'index']);
    Route::post('/faqs', [FaqController::class, 'store']);
    Route::put('/faqs/{faq}', [FaqController::class, 'update']);
    Route::delete('/faqs/{faq}', [FaqController::class, 'destroy']);
    Route::patch('/faqs/{faq}/toggle-active', [FaqController::class, 'toggleActive']);

    // Newsletter
    Route::get('/newsletter', [NewsletterController::class, 'index']);
    Route::patch('/newsletter/{newsletter}/toggle-status', [NewsletterController::class, 'toggleStatus']);

    // Popups
    Route::get('/popups', [PopupController::class, 'index']);
    Route::post('/popups', [PopupController::class, 'store']);
    Route::put('/popups/{popup}', [PopupController::class, 'update']);
    Route::delete('/popups/{popup}', [PopupController::class, 'destroy']);
    Route::patch('/popups/{popup}/toggle-active', [PopupController::class, 'toggleActive']);

    // Users & Roles
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);

    // System Control
    Route::get('/system', [SystemController::class, 'index']);
    Route::post('/system/cache/{type}', [SystemController::class, 'clearCache']);

    // Careers: Job Postings & Applications
    Route::get('/careers', [JobPostingController::class, 'index']);
    Route::post('/careers/jobs', [JobPostingController::class, 'store']);
    Route::put('/careers/jobs/{jobPosting}', [JobPostingController::class, 'update']);
    Route::delete('/careers/jobs/{jobPosting}', [JobPostingController::class, 'destroy']);
    Route::patch('/careers/jobs/{jobPosting}/toggle-active', [JobPostingController::class, 'toggleActive']);
    Route::patch('/careers/applications/{jobApplication}/status', [JobApplicationController::class, 'updateStatus']);
});

// Public form submissions
Route::post('/submit-contact', [App\Http\Controllers\FormSubmissionController::class, 'submitContact']);
Route::post('/submit-lead', [App\Http\Controllers\FormSubmissionController::class, 'submitLead']);
Route::post('/submit-application', [App\Http\Controllers\FormSubmissionController::class, 'submitApplication']);
Route::post('/submit-order', [App\Http\Controllers\FormSubmissionController::class, 'submitOrder']);

// Catch unmatched public URLs to power the 404 monitor
Route::fallback(function () {
    $path = '/'.ltrim(request()->path(), '/');

    if (! str_starts_with($path, '/admin')) {
        $log = NotFoundLog::firstOrNew(['url_path' => $path]);
        $log->referrer = request()->headers->get('referer');
        $log->hit_count = ($log->exists ? $log->hit_count : 0) + 1;
        $log->last_hit_at = now();
        $log->save();
    }

    abort(404);
});
