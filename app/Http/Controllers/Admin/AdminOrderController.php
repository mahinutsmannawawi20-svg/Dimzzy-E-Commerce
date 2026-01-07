<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'payment_status' => 'required|in:unpaid,paid,failed,pending',
        ]);

        $order->payment_status = $request->payment_status;
        if($request->payment_status == 'paid' && !$order->paid_at) {
            $order->paid_at = now();
        }
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully');
    }
}
