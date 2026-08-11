<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product): View
    {
        $product->load(['category', 'vendor', 'reviews.user']);

        abort_if(! $product->is_active, 404);
        abort_if($product->vendor->vendor_status !== 'approved', 404);

        return view('products.show', compact('product'));
    }

    public function storeReview(
        Request $request,
        Product $product
    ): RedirectResponse {
        abort_unless(auth()->user()->isCustomer(), 403);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'review' => ['required', 'string', 'max:1000'],
        ]);

        $product->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);

        return back()->with(
            'success',
            'Your review has been submitted successfully.'
        );
    }
}