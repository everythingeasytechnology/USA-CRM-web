<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

// Admin Route Group
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });

    Route::get('/login', function () {
        return view('admin.login');
    });

    Route::get('/settings', function () {
        return view('admin.settings');
    });

    Route::get('/social', function () {
        return view('admin.social');
    });

    Route::get('/services', function () {
        return view('admin.services.index');
    });

    Route::get('/services/create', function () {
        return view('admin.services.create');
    });

    Route::get('/packages', function () {
        return view('admin.packages.index');
    });

    Route::get('/packages/create', function () {
        return view('admin.packages.create');
    });

    Route::get('/addons', function () {
        return view('admin.addons');
    });

    Route::get('/orders', function () {
        return view('admin.orders.index');
    });

    Route::get('/orders/invoice', function () {
        return view('admin.orders.show');
    });

    Route::get('/payment', function () {
        return view('admin.payment');
    });

    Route::get('/blogs', function () {
        return view('admin.blogs.index');
    });

    Route::get('/blogs/create', function () {
        return view('admin.blogs.create');
    });

    Route::get('/media', function () {
        return view('admin.media');
    });

    Route::get('/leads', function () {
        return view('admin.leads.index');
    });

    Route::get('/forms', function () {
        return view('admin.forms');
    });

    Route::get('/pages', function () {
        return view('admin.pages.index');
    });

    Route::get('/legal', function () {
        return view('admin.legal');
    });

    Route::get('/seo', function () {
        return view('admin.seo.index');
    });

    Route::get('/testimonials', function () {
        return view('admin.testimonials');
    });

    Route::get('/team', function () {
        return view('admin.team');
    });

    Route::get('/faqs', function () {
        return view('admin.faqs');
    });

    Route::get('/newsletter', function () {
        return view('admin.newsletter');
    });

    Route::get('/popups', function () {
        return view('admin.popups');
    });

    Route::get('/users', function () {
        return view('admin.users');
    });

    Route::get('/system', function () {
        return view('admin.system');
    });

    Route::get('/careers', function () {
        return view('admin.careers');
    });
});

Route::post('/submit-contact', [App\Http\Controllers\FormSubmissionController::class, 'submitContact']);
Route::post('/submit-lead', [App\Http\Controllers\FormSubmissionController::class, 'submitLead']);
Route::post('/submit-application', [App\Http\Controllers\FormSubmissionController::class, 'submitApplication']);
Route::post('/submit-order', [App\Http\Controllers\FormSubmissionController::class, 'submitOrder']);
