<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'price_asc'  => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                default      => $query->latest(),
            };
        } else {
            $query->latest();
        }

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('shop._products', compact('products'))->render(),
                'pagination' => (string) $products->links()
            ]);
        }

        return view('shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load('category', 'reviews.user');
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)->get();

        return view('shop.show', compact('product', 'related'));
    }
}
