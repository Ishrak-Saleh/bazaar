<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Product $product): View
    {
        $product->load(['category', 'vendor']);

        abort_if(! $product->is_active, 404);
        abort_if($product->vendor->vendor_status !== 'approved', 404);

        return view('products.show', compact('product'));
    }
}
