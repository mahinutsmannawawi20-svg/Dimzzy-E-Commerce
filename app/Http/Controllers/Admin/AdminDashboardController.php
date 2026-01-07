<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Products;
use App\Models\Coupon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'total_products' => Products::count(),
            'active_coupons' => Coupon::where('expired_at', '>', now())->count(),
            'recent_orders' => Order::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
