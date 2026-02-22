<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = \App\Models\Product::where('is_featured', true)
            ->where('is_active', true)
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        $categories = \App\Models\Category::withCount('products')->get();

        return view('home.index', compact('featuredProducts', 'categories'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'    => 'required|email',
            'subject'  => 'required|string|max:255',
            'message'  => 'required|string',
        ]);

        // In a real app, you would send an email or store in DB.
        // For now, we'll just return with success.
        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
