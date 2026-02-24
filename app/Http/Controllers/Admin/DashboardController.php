<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'    => Order::count(),
            'total_revenue'   => Order::where('payment_status', 'paid')->sum('total'),
            'total_customers' => User::where('is_admin', false)->count(),
            'total_products'  => Product::count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'paid_orders'     => Order::where('payment_status', 'paid')->count(),
            'total_messages'  => \App\Models\ContactMessage::count(),
            'unread_messages' => \App\Models\ContactMessage::where('status', 'unread')->count(),
        ];

        // Recent Orders
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Recent Products
        $recentProducts = Product::with('category')->latest()->take(5)->get();

        // Orders by Status (for chart or summary)
        $ordersByStatus = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return view('admin.index', compact('stats', 'recentOrders', 'recentProducts', 'ordersByStatus'));
    }
}
