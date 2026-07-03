<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentGatewayController extends Controller
{
    protected array $fields = [
        'stripe' => ['pub', 'sec'],
        'paypal' => ['client', 'secret'],
        'razorpay' => ['key', 'secret'],
        'upi' => ['id', 'merchant_name', 'bank_account', 'bank_ifsc'],
    ];

    public function index(): View
    {
        $gateways = PaymentGateway::all()->keyBy('gateway');

        return view('admin.payment', compact('gateways'));
    }

    public function update(Request $request): RedirectResponse
    {
        foreach ($this->fields as $gateway => $fields) {
            $credentials = [];
            foreach ($fields as $field) {
                $credentials[$field] = $request->input("{$gateway}_{$field}");
            }

            PaymentGateway::updateOrCreate(
                ['gateway' => $gateway],
                [
                    'is_enabled' => $request->boolean("{$gateway}_enabled"),
                    'is_sandbox' => $request->boolean("{$gateway}_sandbox"),
                    'credentials' => $credentials,
                ]
            );
        }

        return back()->with('success', 'Payment gateway settings saved.');
    }
}
