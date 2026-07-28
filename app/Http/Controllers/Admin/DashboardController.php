<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $revenue = Order::sum('total');
        $ordersCount = Order::count();
        $productsCount = Product::count();
        $customersCount = User::where('role', 'customer')->count();
        $vendorsCount = User::where('role', 'vendor')->count();
        $pendingVendors = User::where('role', 'vendor')->where('vendor_status', 'pending')->latest()->get();
        $latestOrders = Order::latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'revenue',
            'ordersCount',
            'productsCount',
            'customersCount',
            'vendorsCount',
            'pendingVendors',
            'latestOrders'
        ));
    }
}
