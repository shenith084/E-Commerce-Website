<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user   = auth()->user();
        $orders = Order::where('user_id', $user->id)->latest()->take(5)->get();
        return view('dashboard.index', compact('user', 'orders'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items')
            ->latest()
            ->paginate(10);
        return view('dashboard.orders', compact('orders'));
    }

    public function orderShow(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        $order->load('items.product');
        return view('dashboard.order-detail', compact('order'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('dashboard.profile', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        auth()->user()->update($request->only('name', 'phone', 'address'));
        return back()->with('success', 'Profile updated successfully.');
    }

    public function wishlist()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())->with('product')->get();
        return view('dashboard.wishlist', compact('wishlists'));
    }

    public function wishlistToggle(Product $product)
    {
        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Removed from wishlist.');
        }

        Wishlist::create(['user_id' => auth()->id(), 'product_id' => $product->id]);
        return back()->with('success', 'Added to wishlist!');
    }

    public function storeReview(Request $request, Product $product)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $product->id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return back()->with('success', 'Review submitted. Thank you!');
    }
}
