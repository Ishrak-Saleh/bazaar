<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductFreshnessLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')
            ->where('vendor_id', auth()->id())
            ->latest()
            ->get();

        return view('vendor.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('vendor.products.form', [
            'product' => new Product(),
            'categories' => $categories,
            'mode' => 'create',
            'action' => route('vendor.products.store'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request, true);

        $path = $this->handleImageUpload($request);

        Product::create([
            'vendor_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::lower(Str::random(4)),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'arrival_date' => $request->arrival_date,
            'shelf_life_days' => $request->shelf_life_days,
            'freshness_locked_at' => now()->addMinutes(30),
            'image_path' => $path,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('vendor.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product): View
    {
        abort_unless($product->vendor_id === auth()->id(), 403);

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('vendor.products.form', [
            'product' => $product,
            'categories' => $categories,
            'mode' => 'edit',
            'action' => route('vendor.products.update', $product),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->vendor_id === auth()->id(), 403);

        $freshnessLocked = $this->freshnessIsLocked($product);

        $validated = $this->validateProduct($request, ! $freshnessLocked);

        $path = $product->image_path;

        if ($request->hasFile('image')) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }

            $path = $this->handleImageUpload($request);
        }

        $updateData = [
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::lower(Str::random(4)),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'image_path' => $path,
            'is_active' => $request->boolean('is_active'),
        ];

        if (! $freshnessLocked) {

            $oldArrivalDate = $product->arrival_date;
            $oldShelfLifeDays = $product->shelf_life_days;

            $newArrivalDate = $request->arrival_date;
            $newShelfLifeDays = $request->shelf_life_days;

            $updateData['arrival_date'] = $newArrivalDate;
            $updateData['shelf_life_days'] = $newShelfLifeDays;

            if (
                $oldArrivalDate != $newArrivalDate ||
                $oldShelfLifeDays != $newShelfLifeDays
            ) {
                ProductFreshnessLog::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'old_arrival_date' => $oldArrivalDate,
                    'new_arrival_date' => $newArrivalDate,
                    'old_shelf_life_days' => $oldShelfLifeDays,
                    'new_shelf_life_days' => $newShelfLifeDays,
                    'changed_at' => now(),
                ]);
            }
        }

        $product->update($updateData);

        return redirect()
            ->route('vendor.products.index')
            ->with('success', 'Product updated.');
    }

    

    public function destroy(Product $product): RedirectResponse
    {
        abort_unless($product->vendor_id === auth()->id(), 403);

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return back()->with('success', 'Product deleted.');
    }

    private function freshnessIsLocked(Product $product): bool
    {
        return $product->freshness_locked_at !== null
            && now()->greaterThanOrEqualTo($product->freshness_locked_at);
    }

    private function validateProduct(Request $request, bool $validateFreshness = true): array
    {
        $rules = [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:1'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
            'is_active' => ['nullable'],
        ];

        if ($validateFreshness) {
            $rules['arrival_date'] = ['required', 'date'];
            $rules['shelf_life_days'] = ['required', 'integer', 'min:1', 'max:365'];
        }

        return $request->validate($rules);
    }

    private function handleImageUpload(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        return $request->file('image')->store('products', 'public');
    }
}
