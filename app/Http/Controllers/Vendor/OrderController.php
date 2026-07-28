<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $items = OrderItem::with(['order.customer', 'product'])
            ->where('vendor_id', auth()->id())
            ->latest()
            ->get();

        return view('vendor.orders.index', compact('items'));
    }

    public function updateItemStatus(Request $request, OrderItem $item): RedirectResponse
    {
        abort_unless($item->vendor_id === auth()->id(), 403);

        $validated = $request->validate([
            'vendor_status' => ['required', 'in:pending,processing,ready,shipped'],
        ]);

        $item->update($validated);

        return back()->with('success', 'Vendor item status updated.');
    }
}
