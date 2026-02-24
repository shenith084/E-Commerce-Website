<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
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
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Store the message in the database
        ContactMessage::create($validated);

        return back()->with('success', 'Thank you for your message! We will get back to you within 24 hours.');
    }
}
