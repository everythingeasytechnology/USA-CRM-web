<x-layouts.admin active="orders">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[
            ['label' => 'Order Management', 'url' => '/admin/orders'],
            ['label' => 'Invoice ORD-98012']
        ]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Order Details: ORD-98012</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Payment processed via Stripe Checkout on July 02, 2026.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <x-admin.button variant="secondary" size="sm" onclick="window.print()">
                    <x-admin.icon name="document-text" class="w-4 h-4 mr-1.5" />
                    <span>Print Invoice</span>
                </x-admin.button>
                <x-admin.button variant="primary" size="sm" @click="alert('Project milestone status updated!')">
                    <span>Kickoff Project</span>
                </x-admin.button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left panel: Invoice detail lists -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Visual Invoice Printable Card -->
                <x-admin.card>
                    <div class="p-4 space-y-8 select-text">
                        <!-- Invoice Header -->
                        <div class="flex justify-between items-start gap-4 flex-wrap pb-6 border-b border-slate-100 dark:border-slate-800">
                            <div>
                                <span class="h-8 w-8 rounded-lg bg-blue-600 dark:bg-blue-500 flex items-center justify-center text-white font-black text-base inline-block text-center mr-2">A</span>
                                <span class="font-bold text-slate-900 dark:text-white text-base">Anti Gravity CMS</span>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">Suite 404, Tech Park Sector 62<br/>Noida, UP, India</p>
                            </div>
                            <div class="text-right">
                                <h2 class="text-base font-bold text-slate-900 dark:text-white uppercase tracking-wider">INVOICE</h2>
                                <span class="text-xs font-mono text-slate-500 dark:text-slate-450 block mt-1">#ORD-98012</span>
                                <span class="text-[10px] text-slate-400 block mt-1">Date: 2026-07-02</span>
                            </div>
                        </div>

                        <!-- Customer Details block -->
                        <div class="grid grid-cols-2 gap-6 text-xs">
                            <div>
                                <span class="text-slate-450 block uppercase font-bold tracking-wider mb-1">Billed To:</span>
                                <span class="font-bold text-slate-900 dark:text-white block">John Watson</span>
                                <span class="text-slate-600 dark:text-slate-350 block mt-0.5">Baker Street Agency Ltd.</span>
                                <span class="text-slate-500 block mt-0.5">221B Baker St, London, UK</span>
                            </div>
                            <div class="text-right">
                                <span class="text-slate-450 block uppercase font-bold tracking-wider mb-1">Payment Method:</span>
                                <span class="font-semibold text-slate-850 dark:text-slate-200 block">Stripe Credit Card</span>
                                <span class="text-slate-500 font-mono block mt-0.5">Tx ID: ch_3M8e2B1LAx908v</span>
                            </div>
                        </div>

                        <!-- Invoice Items Table -->
                        <div class="border-t border-slate-100 dark:border-slate-850 pt-4">
                            <table class="min-w-full divide-y divide-slate-150 dark:divide-slate-800 text-xs">
                                <thead>
                                    <tr class="text-slate-500 font-semibold uppercase">
                                        <th class="py-2 text-left">Item / Package</th>
                                        <th class="py-2 text-center">Qty</th>
                                        <th class="py-2 text-right">Price</th>
                                        <th class="py-2 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    <tr>
                                        <td class="py-3">
                                            <span class="font-bold text-slate-850 dark:text-slate-205 block">Startup Landing Page Package</span>
                                            <span class="text-[10px] text-slate-450 mt-0.5 block">Includes 5 sections, fully responsive, dark mode toggle.</span>
                                        </td>
                                        <td class="py-3 text-center font-mono">1</td>
                                        <td class="py-3 text-right font-mono">$499.00</td>
                                        <td class="py-3 text-right font-mono">$499.00</td>
                                    </tr>
                                    <tr>
                                        <td class="py-3">
                                            <span class="font-bold text-slate-850 dark:text-slate-205 block">Priority Support SLA Add-on</span>
                                            <span class="text-[10px] text-slate-455 mt-0.5 block">Response guarantee under 2 hours.</span>
                                        </td>
                                        <td class="py-3 text-center font-mono">1</td>
                                        <td class="py-3 text-right font-mono">$99.00</td>
                                        <td class="py-3 text-right font-mono">$99.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Invoice Totals calculations -->
                        <div class="border-t border-slate-100 dark:border-slate-850 pt-4 flex justify-end">
                            <div class="w-64 space-y-1.5 text-xs">
                                <div class="flex justify-between text-slate-500">
                                    <span>Subtotal:</span>
                                    <span class="font-mono text-slate-700 dark:text-slate-300">$598.00</span>
                                </div>
                                <div class="flex justify-between text-emerald-600">
                                    <span>Discount (Code: KICKOFF20):</span>
                                    <span class="font-mono">- $99.00</span>
                                </div>
                                <div class="flex justify-between text-slate-500">
                                    <span>Taxes (GST 18%):</span>
                                    <span class="font-mono text-slate-700 dark:text-slate-300">$89.82</span>
                                </div>
                                <div class="flex justify-between border-t border-slate-100 dark:border-slate-800 pt-2 font-bold text-sm text-slate-900 dark:text-white">
                                    <span>Total Due:</span>
                                    <span class="font-mono">$588.82</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-admin.card>

                <!-- Notes logs -->
                <x-admin.card title="Client Order Notes">
                    <p class="text-xs text-slate-650 dark:text-slate-350 leading-relaxed">
                        "Please configure the primary landing section to use gradient shades matching the everythingeasy.in color palette. The client requested to make the brand logo asset uploadable in both light and dark variations. Launch scheduled before mid-July."
                    </p>
                </x-admin.card>
            </div>

            <!-- Right panel: Order Timeline / Tracking -->
            <div class="space-y-6">
                <!-- Status controls -->
                <x-admin.card title="Execution Status">
                    <div class="space-y-4">
                        <x-admin.form.select name="pay_status" label="Payment Status">
                            <option value="paid" selected>Completed / Paid</option>
                            <option value="pending">Awaiting Escrow</option>
                            <option value="failed">Failed / Refunded</option>
                        </x-admin.form.select>

                        <x-admin.form.select name="order_status" label="Project Milestone">
                            <option value="new">New Enquiry</option>
                            <option value="processing" selected>In Execution / Active</option>
                            <option value="completed">Delivered / Closed</option>
                        </x-admin.form.select>
                    </div>
                </x-admin.card>

                <!-- Timeline audit logs -->
                <x-admin.card title="Order Timeline">
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            <li class="relative pb-6">
                                <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-slate-200 dark:bg-slate-800"></span>
                                <div class="relative flex space-x-3">
                                    <div class="h-8 w-8 rounded-full bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-bold text-3xs ring-4 ring-white dark:ring-slate-900">
                                        PAY
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5">
                                        <p class="text-xs text-slate-800 dark:text-slate-300 font-semibold">Payment Confirmed</p>
                                        <p class="text-[10px] text-slate-500">Processed Stripe Tx #ch_3M8e2B • 2 hours ago</p>
                                    </div>
                                </div>
                            </li>

                            <li class="relative pb-6">
                                <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-slate-200 dark:bg-slate-800"></span>
                                <div class="relative flex space-x-3">
                                    <div class="h-8 w-8 rounded-full bg-blue-50 dark:bg-blue-500/10 text-blue-600 flex items-center justify-center font-bold text-3xs ring-4 ring-white dark:ring-slate-900">
                                        INV
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5">
                                        <p class="text-xs text-slate-800 dark:text-slate-300 font-semibold">Invoice Emailed</p>
                                        <p class="text-[10px] text-slate-500">Sent copy to watson@baker.org • 3 hours ago</p>
                                    </div>
                                </div>
                            </li>

                            <li class="relative pb-2">
                                <div class="relative flex space-x-3">
                                    <div class="h-8 w-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 flex items-center justify-center font-bold text-3xs ring-4 ring-white dark:ring-slate-900">
                                        NEW
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5">
                                        <p class="text-xs text-slate-800 dark:text-slate-300 font-semibold">Order Placed</p>
                                        <p class="text-[10px] text-slate-500">Checkout session completed • 4 hours ago</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </x-admin.card>
            </div>

        </div>
    </div>
</x-layouts.admin>
