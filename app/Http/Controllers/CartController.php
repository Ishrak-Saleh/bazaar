<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    private function cart(): array
    {
        return session()->get('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session()->put('cart', $cart);
    }

    public function index(): View
    {
        $cart = $this->cart();
        $productIds = array_keys($cart);

        $products = Product::query()
            ->with(['vendor', 'category'])
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $items = [];
        $subtotal = 0;

        foreach ($cart as $productId => $qty) {
            if (! isset($products[$productId])) {
                continue;
            }

            $product = $products[$productId];
            $lineTotal = $product->price * $qty;
            $subtotal += $lineTotal;

            $items[] = [
                'product' => $product,
                'qty' => $qty,
                'line_total' => $lineTotal,
            ];
        }

        $deliveryFee = count($items) > 0 ? 50 : 0;
        $discount = 0;
        $total = $subtotal + $deliveryFee - $discount;

        return view('cart.index', compact('items', 'subtotal', 'deliveryFee', 'discount', 'total'));
    }

    public function add(Product $product): RedirectResponse
    {
        abort_if(! $product->is_active, 404);
        abort_if($product->stock < 1, 422, 'Out of stock.');

        $cart = $this->cart();
        $cart[$product->id] = min(($cart[$product->id] ?? 0) + 1, $product->stock);
        $this->saveCart($cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->cart();

        if (! isset($cart[$product->id])) {
            return redirect()->route('cart.index');
        }

        $cart[$product->id] = min((int) $request->qty, $product->stock);
        $this->saveCart($cart);

        return redirect()->route('cart.index');
    }

    public function remove(Product $product): RedirectResponse
    {
        $cart = $this->cart();
        unset($cart[$product->id]);
        $this->saveCart($cart);

        return redirect()->route('cart.index');
    }

    public function clear(): RedirectResponse
    {
        session()->forget('cart');

        return redirect()->route('cart.index');
    }
}
