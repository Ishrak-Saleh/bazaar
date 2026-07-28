<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $vendorId = auth()->id();

        $productsCount = Product::where('vendor_id', $vendorId)->count();
        $ordersCount = OrderItem::where('vendor_id', $vendorId)->distinct('order_id')->count('order_id');
        $earnings = OrderItem::where('vendor_id', $vendorId)->sum('subtotal');
        $recentItems = OrderItem::with(['order.customer', 'product'])
            ->where('vendor_id', $vendorId)
            ->latest()
            ->take(8)
            ->get();

        return view('vendor.dashboard', compact('productsCount', 'ordersCount', 'earnings', 'recentItems'));
    }
}
