<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    private function cart(): array
    {
        return session()->get('cart', []);
    }

    public function show(): View
    {
        $cart = $this->cart();
        abort_if(empty($cart), 404, 'Cart is empty.');

        $products = Product::query()->with(['vendor', 'category'])->whereIn('id', array_keys($cart))->get()->keyBy('id');

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

        return view('checkout.index', compact('items', 'subtotal', 'deliveryFee', 'discount', 'total'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'max:30'],
            'street_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:20'],
            'payment_method' => ['required', 'in:cod,bkash'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $cart = $this->cart();
        abort_if(empty($cart), 404, 'Cart is empty.');

        $productIds = array_keys($cart);
        $products = Product::query()->whereIn('id', $productIds)->get()->keyBy('id');

        $subtotal = 0;
        $deliveryFee = 50;
        $discount = 0;

        foreach ($cart as $productId => $qty) {
            if (! isset($products[$productId])) {
                continue;
            }
            $subtotal += $products[$productId]->price * $qty;
        }

        $total = $subtotal + $deliveryFee - $discount;
        $orderNumber = 'BZ-' . strtoupper(Str::random(6));

        $order = DB::transaction(function () use ($validated, $cart, $products, $subtotal, $deliveryFee, $discount, $total, $orderNumber) {
            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_id' => auth()->id(),
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'street_address' => $validated['street_address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'payment_method' => $validated['payment_method'],
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'discount' => $discount,
                'total' => $total,
                'status' => 'processing',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($cart as $productId => $qty) {
                if (! isset($products[$productId])) {
                    continue;
                }

                $product = $products[$productId];
                $lineTotal = $product->price * $qty;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'vendor_id' => $product->vendor_id,
                    'product_name' => $product->name,
                    'unit_price' => $product->price,
                    'quantity' => $qty,
                    'subtotal' => $lineTotal,
                    'vendor_status' => 'processing',
                ]);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully.');
    }

    public function confirmation(Order $order): View
    {
        $order->load(['items.product', 'items.vendor']);

        abort_if($order->customer_id !== auth()->id() && ! auth()->user()->isAdmin(), 403);

        return view('checkout.confirmation', compact('order'));
    }
}
