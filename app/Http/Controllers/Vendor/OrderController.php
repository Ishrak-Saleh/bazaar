<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Mail\OrderStatusUpdateMail;
use Illuminate\Support\Facades\Mail;
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

    public function updateItemStatus(
        Request $request,
        OrderItem $item
    ): RedirectResponse {
        abort_unless($item->vendor_id === auth()->id(), 403);

        $validated = $request->validate([
            'vendor_status' => [
                'required',
                'in:processing,ready,shipped,cancelled',
            ],
        ]);

        $newStatus = $validated['vendor_status'];
        $currentStatus = $item->vendor_status;


        if ($currentStatus === 'cancelled') {
            return back()->with(
                'error',
                'A cancelled order item cannot be updated.'
            );
        }

        if ($currentStatus === 'shipped') {
            return back()->with(
                'error',
                'A shipped order item cannot be updated.'
            );
        }

        $allowedTransitions = [
            'processing' => ['ready', 'cancelled'],
            'ready' => ['shipped', 'cancelled'],
            'shipped' => [],
            'cancelled' => [],
        ];

        if (
            !in_array(
                $newStatus,
                $allowedTransitions[$currentStatus] ?? [],
                true
            )
        ) {
            return back()->with(
                'error',
                'Invalid order status change.'
            );
        }

        $item->update([
            'vendor_status' => $newStatus,
        ]);

        $order = $item->order;

        $statuses = $order->items()->pluck('vendor_status');

        if ($statuses->contains('cancelled')) {
            $orderStatus = 'cancelled';
        } elseif ($statuses->every(
            fn ($status) => $status === 'shipped'
        )) {
            $orderStatus = 'shipped';
        } elseif ($statuses->every(
            fn ($status) => in_array(
                $status,
                ['ready', 'shipped'],
                true
            )
        )) {
            $orderStatus = 'ready';
        } else {
            $orderStatus = 'processing';
        }

        $order->update([
            'status' => $orderStatus,
        ]);

        Mail::to($order->email)->send(
            new OrderStatusUpdateMail(
                $order,
                $item,
                $newStatus
            )
        );

        return back()->with(
            'success',
            'Order status updated successfully.'
        );
    }
}