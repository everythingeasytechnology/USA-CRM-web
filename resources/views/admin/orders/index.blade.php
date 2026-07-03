<x-layouts.admin active="orders">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Order Management']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Order Management</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Review customer invoice generation, coupon code applications, and checkout records.</p>
            </div>
        </div>

        <!-- Filters & Statistics widgets -->
        <x-admin.card>
            <form method="GET" action="/admin/orders" class="flex flex-wrap items-center justify-between gap-4">
                <div class="w-full sm:max-w-xs relative">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search orders..."
                        class="w-full pl-9 pr-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg text-sm bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-admin.icon name="search" class="w-4 h-4 text-slate-400" />
                    </div>
                </div>

                <div class="flex items-center gap-2.5 flex-wrap">
                    <select name="status" class="text-xs bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg p-2 text-slate-700 dark:text-slate-300">
                        <option value="">Payment Status</option>
                        <option value="paid" @selected(request('status') === 'paid')>Paid</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                        <option value="refunded" @selected(request('status') === 'refunded')>Refunded</option>
                        <option value="failed" @selected(request('status') === 'failed')>Failed</option>
                    </select>
                    <x-admin.button type="submit" variant="secondary" size="sm">
                        Filter
                    </x-admin.button>
                </div>
            </form>
        </x-admin.card>

        <!-- Orders list log -->
        <x-admin.card :padding="false">
            <x-admin.table :headers="['Order ID', 'Customer Details', 'Package Purchased', 'Amount', 'Payment', 'Order Status', 'Actions']">
                @forelse ($orders as $order)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors">
                        <td class="px-6 py-4 font-mono text-xs font-bold text-slate-900 dark:text-white">
                            {{ $order->order_number }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-850 dark:text-slate-200 text-xs block leading-tight">{{ $order->client_name }}</span>
                            <span class="text-[10px] text-slate-450 block mt-0.5">{{ $order->email }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-semibold text-slate-700 dark:text-slate-350">
                            {{ $order->service_name }}
                        </td>
                        <td class="px-6 py-4 text-xs font-mono font-bold text-slate-850 dark:text-slate-200">
                            ${{ number_format($order->amount, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($order->status === 'paid')
                                <x-admin.badge variant="success">Paid</x-admin.badge>
                            @elseif ($order->status === 'pending')
                                <x-admin.badge variant="warning">Pending</x-admin.badge>
                            @elseif ($order->status === 'refunded')
                                <x-admin.badge variant="danger">Refunded</x-admin.badge>
                            @else
                                <x-admin.badge variant="danger">Failed</x-admin.badge>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($order->status === 'paid')
                                <x-admin.badge variant="success">Completed</x-admin.badge>
                            @elseif ($order->status === 'pending')
                                <x-admin.badge variant="warning">New Order</x-admin.badge>
                            @else
                                <x-admin.badge variant="neutral">Cancelled</x-admin.badge>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <x-admin.button variant="secondary" size="xs" href="/admin/orders/{{ $order->id }}" title="View Invoice">
                                <x-admin.icon name="eye" class="w-4 h-4 mr-1.5" />
                                <span>Invoice</span>
                            </x-admin.button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-xs text-slate-400">
                            No billing orders recorded yet.
                        </td>
                    </tr>
                @endforelse
            </x-admin.table>

            <x-admin.pagination :currentPage="1" :totalPages="1" :totalResults="$orders->count()" :perPage="max($orders->count(), 1)" />
        </x-admin.card>
    </div>
</x-layouts.admin>
