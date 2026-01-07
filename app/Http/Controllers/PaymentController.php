<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Coupon;
use App\Helpers\CartHelper;
use App\Services\YoGatewayService;
use Carbon\Carbon;

class PaymentController extends Controller
{
    private $yogateway;

    public function __construct(YoGatewayService $yogateway)
    {
        $this->yogateway = $yogateway;
    }

    /**
     * Show checkout form
     */
    public function showCheckout()
    {
        $cart = CartHelper::getCart();
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        $cartTotal = CartHelper::getCartTotal();
        $appliedCouponCode = CartHelper::getAppliedCoupon();
        $coupon = null;
        $discountAmount = 0;
        $finalTotal = $cartTotal;

        if ($appliedCouponCode) {
            $coupon = Coupon::where('code', $appliedCouponCode)->first();
            if ($coupon && $coupon->isValid() && $coupon->canApplyTo($cartTotal)) {
                $discountAmount = $coupon->calculateDiscount($cartTotal);
                $finalTotal = $cartTotal - $discountAmount;
            }
        }

        return view('checkout', compact('cart', 'cartTotal', 'coupon', 'discountAmount', 'finalTotal'));
    }

    /**
     * Create payment
     */
    public function createPayment(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:100',
            'customer_phone' => 'required|string|max:20',
        ]);

        $cart = CartHelper::getCart();
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        $cartTotal = CartHelper::getCartTotal();
        $appliedCouponCode = CartHelper::getAppliedCoupon();
        $discountAmount = 0;

        // Apply coupon if exists
        if ($appliedCouponCode) {
            $coupon = Coupon::where('code', $appliedCouponCode)->first();
            if ($coupon && $coupon->isValid() && $coupon->canApplyTo($cartTotal)) {
                $discountAmount = $coupon->calculateDiscount($cartTotal);
            } else {
                CartHelper::removeCoupon();
                $appliedCouponCode = null;
            }
        }

        $finalTotal = $cartTotal - $discountAmount;

        // Create order
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'items' => $cart,
            'subtotal' => $cartTotal,
            'discount_amount' => $discountAmount,
            'total_amount' => $finalTotal,
            'coupon_code' => $appliedCouponCode,
            'payment_status' => 'pending',
        ]);

        // Create payment via YoGateway
        $paymentData = $this->yogateway->createPayment($finalTotal);

        if (!$paymentData) {
            $order->update(['payment_status' => 'failed']);
            return redirect()->route('payment.failed')->with('error', 'Gagal membuat pembayaran. Silakan coba lagi.');
        }

        // Update order with payment data
        $order->update([
            'yogateway_trxid' => $paymentData['trxid'],
            'qris_image_url' => $paymentData['qris_image'],
            'expired_at' => Carbon::parse($paymentData['expired']),
        ]);

        // Create payment record
        Payment::create([
            'order_id' => $order->id,
            'trxid' => $paymentData['trxid'],
            'amount' => $paymentData['nominal'],
            'status' => 'pending',
            'qris_image_url' => $paymentData['qris_image'],
            'response_data' => $paymentData,
        ]);

        // Redirect to payment page
        return view('payment.qris', compact('order', 'paymentData'));
    }

    /**
     * Check payment status
     */
    public function checkStatus($orderId)
    {
        $order = Order::findOrFail($orderId);

        if (!$order->yogateway_trxid) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction ID not found'
            ]);
        }

        $status = $this->yogateway->checkStatus($order->yogateway_trxid);

        if ($status && $status['status'] === 'SUCCESS') {
            // Update order
            $order->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

            // Update payment
            $payment = $order->payments()->where('trxid', $order->yogateway_trxid)->first();
            if ($payment) {
                $payment->update([
                    'status' => 'success',
                    'response_data' => $status,
                ]);
            }

            // Mark coupon as used
            if ($order->coupon_code) {
                $coupon = Coupon::where('code', $order->coupon_code)->first();
                if ($coupon) {
                    $coupon->markAsUsed();
                }
            }

            // Clear cart
            CartHelper::clearCart();

            return response()->json([
                'success' => true,
                'status' => 'paid',
                'redirect' => route('payment.success', ['orderId' => $order->id])
            ]);
        }

        return response()->json([
            'success' => true,
            'status' => $order->payment_status
        ]);
    }

    /**
     * Payment success page
     */
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('payment.success', compact('order'));
    }

    /**
     * Payment failed page
     */
    public function failed()
    {
        return view('payment.failed');
    }
}
