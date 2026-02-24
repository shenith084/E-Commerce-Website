<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $user  = auth()->user();

        return view('checkout.index', compact('cart', 'total', 'user'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_name'    => 'required|string|max:255',
            'shipping_email'   => 'required|email',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city'    => 'required|string|max:100',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id'          => auth()->id(),
                'order_number'     => Order::generateOrderNumber(),
                'status'           => 'pending',
                'subtotal'         => $subtotal,
                'total'            => $subtotal,
                'shipping_name'    => $request->shipping_name,
                'shipping_email'   => $request->shipping_email,
                'shipping_phone'   => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city'    => $request->shipping_city,
                'payment_status'   => 'pending',
                'payment_method'   => 'payhere',
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['id'],
                    'product_name' => $item['name'],
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],
                    'subtotal'     => $item['price'] * $item['quantity'],
                ]);

                // Decrement stock
                Product::where('id', $item['id'])->decrement('stock', $item['quantity']);
            }

            DB::commit();

            // Clear the cart now that the order is placed
            session()->forget('cart');

            // Store order ID for payment
            session()->put('pending_order_id', $order->id);
            return redirect()->route('payment.pay', $order);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Order failed. Please try again.');
        }
    }
}
