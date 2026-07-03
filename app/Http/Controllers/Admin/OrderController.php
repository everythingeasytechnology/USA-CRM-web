<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::query()->latest();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $orders = $query->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('items');

        $items = $order->items->isNotEmpty()
            ? $order->items
            : collect([
                new OrderItem([
                    'name' => $order->service_name,
                    'quantity' => 1,
                    'unit_price' => $order->amount,
                    'line_total' => $order->amount,
                ]),
            ]);

        $subtotal = $items->sum('line_total');
        $total = $subtotal - $order->discount + $order->tax;

        return view('admin.orders.show', compact('order', 'items', 'subtotal', 'total'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,refunded,failed',
        ]);

        $order->update($validated);

        return back()->with('success', 'Order status updated.');
    }
}
