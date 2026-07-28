<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()
            ->with(['items.product', 'items.vendor'])
            ->where('customer_id', auth()->id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        abort_if($order->customer_id !== auth()->id() && ! auth()->user()->isAdmin(), 403);

        $order->load(['items.product', 'items.vendor']);

        return view('orders.show', compact('order'));
    }
}
