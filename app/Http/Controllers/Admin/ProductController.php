<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active')   $query->where('is_active', true);
            if ($request->status === 'inactive') $query->where('is_active', false);
            if ($request->status === 'featured') $query->where('is_featured', true);
            if ($request->status === 'low_stock') $query->where('stock', '<', 5)->where('stock', '>', 0);
            if ($request->status === 'out_of_stock') $query->where('stock', 0);
        }

        $products   = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_active'   => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['slug']        = Str::slug($data['name']) . '-' . uniqid();
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);

        $product = Product::create($data);

        return redirect()->route('admin.products.show', $product)
            ->with('success', '✅ Product "' . $product->name . '" created successfully!');
    }

    public function show(Product $product)
    {
        $product->load('category', 'reviews.user', 'orderItems');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string|max:2000',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured'  => 'boolean',
            'is_active'    => 'boolean',
            'remove_image' => 'boolean',
        ]);

        // Handle image removal
        if ($request->boolean('remove_image') && $product->image) {
            Storage::disk('public')->delete($product->image);
            $data['image'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active');

        $product->update($data);

        return redirect()->route('admin.products.show', $product)
            ->with('success', '✅ Product "' . $product->name . '" updated successfully!');
    }

    public function destroy(Product $product)
    {
        $name = $product->name;
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', '🗑️ Product "' . $name . '" deleted.');
    }
}
