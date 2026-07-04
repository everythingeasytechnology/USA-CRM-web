<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Package;
use App\Models\Blog;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class FrontendController extends Controller
{
    /**
     * Public Homepage
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * About Us Page
     */
    public function about()
    {
        return view('frontend.about');
    }

    /**
     * Portfolio Page
     */
    public function portfolio()
    {
        return view('frontend.portfolio');
    }

    /**
     * Services Directory
     */
    public function services()
    {
        $services = Service::where('is_active', true)->orderBy('display_order')->get();
        return view('frontend.services', compact('services'));
    }

    /**
     * Show service with Programmatic SEO (Location bracket engine)
     */
    public function showService($slug)
    {
        $city = null;
        $state = 'Uttarakhand';
        
        // Parse programmatic SEO location suffix, e.g., web-development-in-dehradun
        if (preg_match('/^(.*)-in-(.*)$/', $slug, $matches)) {
            $serviceSlug = $matches[1];
            $citySlug = $matches[2];
            $city = ucwords(str_replace('-', ' ', $citySlug));
        } else {
            $serviceSlug = $slug;
        }

        $service = Service::where('slug', $serviceSlug)->first();

        if (!$service) {
            abort(404);
        }

        $packages = Package::where('service_id', $service->id)->get();

        return view('frontend.service_show', compact('service', 'city', 'state', 'packages'));
    }

    /**
     * Careers portal vacancies
     */
    public function careers()
    {
        $jobs = JobPosting::where('status', true)->latest()->get();
        return view('frontend.careers', compact('jobs'));
    }

    /**
     * Blogs catalog listing
     */
    public function blogs()
    {
        $blogs = Blog::where('is_published', true)->latest()->get();
        return view('frontend.blogs', compact('blogs'));
    }

    /**
     * Single Blog Post
     */
    public function showBlog($slug)
    {
        $blog = Blog::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('frontend.blog_show', compact('blog'));
    }

    /**
     * Contact form landing page
     */
    public function contact()
    {
        return view('frontend.contact');
    }

    /**
     * Package checkout page
     */
    public function checkout(Package $package)
    {
        $package->load('service');
        return view('frontend.checkout', compact('package'));
    }

    /**
     * Create order in pending status before PayPal checkout
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'client_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'billing_address' => 'required|string',
            'company_name' => 'nullable|string|max:255',
        ]);

        $package = Package::findOrFail($request->package_id);
        $package->load('service');

        $orderNumber = 'ORD-' . strtoupper(uniqid());

        // Create Order
        $order = \App\Models\Order::create([
            'order_number' => $orderNumber,
            'client_name' => $request->client_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'service_name' => $package->service->name . ' - ' . $package->name,
            'amount' => $package->price,
            'status' => 'pending',
            'billing_address' => $request->billing_address,
        ]);

        // Create Order Item
        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'name' => $package->name,
            'quantity' => 1,
            'unit_price' => $package->price,
            'line_total' => $package->price,
        ]);

        // Capture lead as well for tracking
        \App\Models\Lead::create([
            'name' => $request->client_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'service_requested' => $package->service->name,
            'budget' => 'growth',
            'country' => 'USA',
            'source' => 'Checkout Page',
            'notes' => 'Purchased Package: ' . $package->name . ' via PayPal Checkout. Company: ' . ($request->company_name ?? 'N/A'),
            'status' => 'new'
        ]);

        // Price is already in USD
        $usdAmount = $package->price;

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'order_number' => $orderNumber,
            'usd_amount' => $usdAmount,
        ]);
    }

    /**
     * Mark order as paid on PayPal payment approval
     */
    public function paymentSuccess(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = \App\Models\Order::findOrFail($request->order_id);
        $order->update(['status' => 'paid']);

        try {
            // Send Confirmation Email to Customer
            Mail::to($order->email)->send(new OrderConfirmation($order));

            // Send Alert Email to Admin/Sales team
            $salesEmail = \App\Models\Setting::get('sales_email', 'sales@everythingeasy.in');
            Mail::to($salesEmail)->send(new OrderConfirmation($order));
        } catch (\Exception $e) {
            logger()->error('Order confirmation email dispatch failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'redirect_url' => url('/checkout/success/' . $order->order_number),
        ]);
    }

    /**
     * Checkout Thank You / Success screen
     */
    public function checkoutSuccess($orderNumber)
    {
        $order = \App\Models\Order::where('order_number', $orderNumber)->firstOrFail();
        return view('frontend.checkout_success', compact('order'));
    }
}
