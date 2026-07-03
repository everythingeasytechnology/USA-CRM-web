<x-layouts.admin active="payment">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Payment Gateways Settings']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Payment Gateways Settings</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure merchant API keys, sandbox checkout redirects, and webhook endpoints.</p>
        </div>

        @php
            $stripe = $gateways->get('stripe');
            $paypal = $gateways->get('paypal');
            $razorpay = $gateways->get('razorpay');
            $upi = $gateways->get('upi');
        @endphp

        <form action="/admin/payment" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Gateway: Stripe -->
                <x-admin.card title="Stripe integration">
                    <x-slot:actions>
                        <x-admin.form.toggle name="stripe_enabled" :value="$stripe->is_enabled ?? false" />
                    </x-slot:actions>
                    <div class="space-y-4 mt-2">
                        <div class="flex items-center gap-3 mb-2">
                            <x-admin.form.toggle name="stripe_sandbox" label="Stripe Sandbox / Test Mode" :value="$stripe->is_sandbox ?? true" />
                        </div>
                        <x-admin.form.input name="stripe_pub" label="Stripe Publishable Key" :value="$stripe->credentials['pub'] ?? ''" />
                        <x-admin.form.input name="stripe_sec" type="password" label="Stripe Secret Key" :value="$stripe->credentials['sec'] ?? ''" />
                        <x-admin.form.input name="stripe_webhook" label="Webhook URL" value="{{ url('/api/v1/stripe/webhook') }}" :readonly="true" help="Register this callback URL inside Stripe developer console" />
                    </div>
                </x-admin.card>

                <!-- Gateway: PayPal -->
                <x-admin.card title="PayPal Checkout">
                    <x-slot:actions>
                        <x-admin.form.toggle name="paypal_enabled" :value="$paypal->is_enabled ?? false" />
                    </x-slot:actions>
                    <div class="space-y-4 mt-2">
                        <div class="flex items-center gap-3 mb-2">
                            <x-admin.form.toggle name="paypal_sandbox" label="PayPal Sandbox Mode" :value="$paypal->is_sandbox ?? true" />
                        </div>
                        <x-admin.form.input name="paypal_client" label="PayPal Client ID" placeholder="Enter PayPal Sandbox/Production Client ID" :value="$paypal->credentials['client'] ?? ''" />
                        <x-admin.form.input name="paypal_secret" type="password" label="PayPal Secret Key" :value="$paypal->credentials['secret'] ?? ''" />
                        <x-admin.form.input name="paypal_webhook" label="Webhook URL" value="{{ url('/api/v1/paypal/webhook') }}" :readonly="true" />
                    </div>
                </x-admin.card>

                <!-- Gateway: Razorpay -->
                <x-admin.card title="Razorpay Merchant Details">
                    <x-slot:actions>
                        <x-admin.form.toggle name="razorpay_enabled" :value="$razorpay->is_enabled ?? false" />
                    </x-slot:actions>
                    <div class="space-y-4 mt-2">
                        <div class="flex items-center gap-3 mb-2">
                            <x-admin.form.toggle name="razorpay_sandbox" label="Test Mode" :value="$razorpay->is_sandbox ?? true" />
                        </div>
                        <x-admin.form.input name="razorpay_key" label="Razorpay Key ID" :value="$razorpay->credentials['key'] ?? ''" />
                        <x-admin.form.input name="razorpay_secret" type="password" label="Razorpay Secret Key" :value="$razorpay->credentials['secret'] ?? ''" />
                        <x-admin.form.input name="razorpay_webhook" label="Webhook URL" value="{{ url('/api/v1/razorpay/webhook') }}" :readonly="true" />
                    </div>
                </x-admin.card>

                <!-- Gateway: UPI / Bank Transfer -->
                <x-admin.card title="Direct UPI / QR & Bank Details">
                    <x-slot:actions>
                        <x-admin.form.toggle name="upi_enabled" :value="$upi->is_enabled ?? false" />
                    </x-slot:actions>
                    <div class="space-y-4 mt-2">
                        <x-admin.form.input name="upi_id" label="Merchant UPI ID (VPA)" :value="$upi->credentials['id'] ?? ''" help="Used for generating automated QR codes during checkout" />
                        <x-admin.form.input name="upi_merchant_name" label="Merchant Account Name" :value="$upi->credentials['merchant_name'] ?? ''" />
                        <div class="grid grid-cols-2 gap-4">
                            <x-admin.form.input name="upi_bank_account" label="Bank Account Number" :value="$upi->credentials['bank_account'] ?? ''" />
                            <x-admin.form.input name="upi_bank_ifsc" label="Bank IFSC Code" :value="$upi->credentials['bank_ifsc'] ?? ''" />
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <!-- Submission -->
            <div class="flex justify-end border-t border-slate-200 dark:border-slate-800 pt-6">
                <x-admin.button type="submit" variant="primary">
                    <x-admin.icon name="check" class="w-5 h-5" />
                    <span>Save Gateways</span>
                </x-admin.button>
            </div>

        </form>
    </div>
</x-layouts.admin>
