<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductFreshnessChangeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductFreshnessChangeRequestController extends Controller
{
    public function store(
        Request $request,
        Product $product
    ): RedirectResponse {
        if ($product->vendor_id !== auth()->id()) {
            abort(403);
        }

        if (
            $product->freshness_locked_at === null
            || now()->lessThan($product->freshness_locked_at)
        ) {
            return back()->with(
                'error',
                'This product is still within the freshness modification period.'
            );
        }

        $validated = $request->validate([
            'requested_arrival_date' => [
                'required',
                'date',
            ],
            'requested_shelf_life_days' => [
                'required',
                'integer',
                'min:1',
            ],
            'reason' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

 
        if (
            $product->arrival_date->format('Y-m-d') === $validated['requested_arrival_date']
            && (int) $product->shelf_life_days === (int) $validated['requested_shelf_life_days']
        ) {
            return back()->with(
                'error',
                'The requested freshness information is the same as the current information.'
            );
        }


        $existingPendingRequest = ProductFreshnessChangeRequest::where(
            'product_id',
            $product->id
        )
            ->where('vendor_id', auth()->id())
            ->where('status', 'pending')
            ->exists();

        if ($existingPendingRequest) {
            return back()->with(
                'error',
                'You already have a pending freshness change request for this product.'
            );
        }


        ProductFreshnessChangeRequest::create([
            'product_id' => $product->id,
            'vendor_id' => auth()->id(),
            'current_arrival_date' => $product->arrival_date,
            'requested_arrival_date' => $validated['requested_arrival_date'],
            'current_shelf_life_days' => $product->shelf_life_days,
            'requested_shelf_life_days' => $validated['requested_shelf_life_days'],
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return back()->with(
            'success',
            'Freshness change request submitted to the administrator.'
        );
    }

}