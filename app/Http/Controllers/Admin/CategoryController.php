<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string|max:500',
        ]);

        $slug = Str::slug($data['name']);
        
        // Ensure slug is unique
        $count = Category::where('slug', 'like', $slug . '%')->count();
        $data['slug'] = $count > 0 ? "{$slug}-" . ($count + 1) : $slug;

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', '✅ Category "' . $data['name'] . '" created successfully.');
    }

    public function edit(Category $category)
    {
        $category->loadCount('products');
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
        ]);

        if ($data['name'] !== $category->name) {
            $slug = Str::slug($data['name']);
            $count = Category::where('slug', 'like', $slug . '%')->where('id', '!=', $category->id)->count();
            $data['slug'] = $count > 0 ? "{$slug}-" . ($count + 1) : $slug;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', '✅ Category "' . $category->name . '" updated successfully.');
    }

    public function destroy(Category $category)
    {
        $name = $category->name;
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', '🗑️ Category "' . $name . '" deleted.');
    }
}
