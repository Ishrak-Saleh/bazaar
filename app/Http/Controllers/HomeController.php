<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()
            ->with(['category', 'vendor'])
            ->where('is_active', true)
            ->whereHas('vendor', fn ($q) => $q->where('vendor_status', 'approved'));

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($sub) => $sub->where('slug', $request->string('category')));
        }

        $products = $query->latest()->get();
        $categories = Category::query()->where('is_active', true)->orderBy('name')->get();

        return view('home', compact('products', 'categories'));
    }
}
