<x-layouts.admin active="orders">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[
            ['label' => 'Order Management', 'url' => '/admin/orders'],
            ['label' => 'Invoice '.$order->order_number]
        ]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Order Details: {{ $order->order_number }}</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Placed on {{ $order->created_at->format('F d, Y') }}.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <x-admin.button variant="secondary" size="sm" onclick="window.print()">
                    <x-admin.icon name="document-text" class="w-4 h-4 mr-1.5" />
                    <span>Print Invoice</span>
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
                                <span class="font-bold text-slate-900 dark:text-white text-base">EverythingEasy</span>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">{{ \App\Models\Setting::get('company_address', '') }}</p>
                            </div>
                            <div class="text-right">
                                <h2 class="text-base font-bold text-slate-900 dark:text-white uppercase tracking-wider">INVOICE</h2>
                                <span class="text-xs font-mono text-slate-500 dark:text-slate-450 block mt-1">#{{ $order->order_number }}</span>
                                <span class="text-[10px] text-slate-400 block mt-1">Date: {{ $order->created_at->format('Y-m-d') }}</span>
                            </div>
                        </div>

                        <!-- Customer Details block -->
                        <div class="grid grid-cols-2 gap-6 text-xs">
                            <div>
                                <span class="text-slate-450 block uppercase font-bold tracking-wider mb-1">Billed To:</span>
                                <span class="font-bold text-slate-900 dark:text-white block">{{ $order->client_name }}</span>
                                <span class="text-slate-600 dark:text-slate-350 block mt-0.5">{{ $order->email }}</span>
                                @if ($order->billing_address)
                                    <span class="text-slate-500 block mt-0.5">{{ $order->billing_address }}</span>
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="text-slate-450 block uppercase font-bold tracking-wider mb-1">Payment Status:</span>
                                <span class="font-semibold text-slate-850 dark:text-slate-200 block capitalize">{{ $order->status }}</span>
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
                                    @foreach ($items as $item)
                                        <tr>
                                            <td class="py-3">
                                                <span class="font-bold text-slate-850 dark:text-slate-205 block">{{ $item->name }}</span>
                                            </td>
                                            <td class="py-3 text-center font-mono">{{ $item->quantity }}</td>
                                            <td class="py-3 text-right font-mono">${{ number_format($item->unit_price, 2) }}</td>
                                            <td class="py-3 text-right font-mono">${{ number_format($item->line_total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Invoice Totals calculations -->
                        <div class="border-t border-slate-100 dark:border-slate-850 pt-4 flex justify-end">
                            <div class="w-64 space-y-1.5 text-xs">
                                <div class="flex justify-between text-slate-500">
                                    <span>Subtotal:</span>
                                    <span class="font-mono text-slate-700 dark:text-slate-300">${{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-emerald-600">
                                    <span>Discount:</span>
                                    <span class="font-mono">- ${{ number_format($order->discount, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-slate-500">
                                    <span>Taxes:</span>
                                    <span class="font-mono text-slate-700 dark:text-slate-300">${{ number_format($order->tax, 2) }}</span>
                                </div>
                                <div class="flex justify-between border-t border-slate-100 dark:border-slate-800 pt-2 font-bold text-sm text-slate-900 dark:text-white">
                                    <span>Total Due:</span>
                                    <span class="font-mono">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <!-- Right panel: Order Timeline / Tracking -->
            <div class="space-y-6">
                <!-- Status controls -->
                <x-admin.card title="Execution Status">
                    <form method="POST" action="/admin/orders/{{ $order->id }}/status" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <x-admin.form.select name="status" label="Payment Status">
                            <option value="paid" @selected($order->status === 'paid')>Completed / Paid</option>
                            <option value="pending" @selected($order->status === 'pending')>Pending</option>
                            <option value="refunded" @selected($order->status === 'refunded')>Refunded</option>
                            <option value="failed" @selected($order->status === 'failed')>Failed</option>
                        </x-admin.form.select>
                        <x-admin.button type="submit" variant="primary" size="sm" class="w-full">Update Status</x-admin.button>
                    </form>
                </x-admin.card>

                <!-- Timeline audit logs -->
                <x-admin.card title="Order Timeline">
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            <li class="relative pb-6">
                                <div class="relative flex space-x-3">
                                    <div class="h-8 w-8 rounded-full {{ $order->status === 'paid' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }} flex items-center justify-center font-bold text-3xs ring-4 ring-white dark:ring-slate-900">
                                        PAY
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5">
                                        <p class="text-xs text-slate-800 dark:text-slate-300 font-semibold capitalize">Status: {{ $order->status }}</p>
                                        <p class="text-[10px] text-slate-500">Last updated {{ $order->updated_at->diffForHumans() }}</p>
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
                                        <p class="text-[10px] text-slate-500">{{ $order->created_at->diffForHumans() }}</p>
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
