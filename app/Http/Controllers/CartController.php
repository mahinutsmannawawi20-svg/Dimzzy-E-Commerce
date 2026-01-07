<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CartHelper;
use App\Models\Coupon;
use App\Models\Products;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {
        $cart = CartHelper::getCart();
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
            } else {
                // Remove invalid coupon
                CartHelper::removeCoupon();
                $coupon = null;
            }
        }

        return view('cart', compact('cart', 'cartTotal', 'coupon', 'discountAmount', 'finalTotal'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1',
        ]);

        $quantity = $request->quantity ?? 1;
        CartHelper::addToCart($request->product_id, $quantity);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cart_count' => CartHelper::getCartCount(),
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:0',
        ]);

        CartHelper::updateCart($request->product_id, $request->quantity);

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diupdate!',
            'cart_total' => CartHelper::getCartTotal(),
            'cart_count' => CartHelper::getCartCount(),
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove($productId)
    {
        CartHelper::removeFromCart($productId);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus dari keranjang!',
            'cart_total' => CartHelper::getCartTotal(),
            'cart_count' => CartHelper::getCartCount(),
        ]);
    }

    /**
     * Apply coupon to cart
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();
        $cartTotal = CartHelper::getCartTotal();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Kode kupon tidak valid!'
            ], 404);
        }

        if ($coupon->is_used) {
            return response()->json([
                'success' => false,
                'message' => 'Kupon sudah pernah digunakan!'
            ], 400);
        }

        if ($coupon->expired_at < now()) {
            return response()->json([
                'success' => false,
                'message' => 'Kupon sudah kadaluarsa!'
            ], 400);
        }

        if ($cartTotal < $coupon->min_purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal pembelian Rp ' . number_format((float)$coupon->min_purchase, 0, ',', '.') . ' untuk menggunakan kupon ini!'
            ], 400);
        }

        CartHelper::applyCoupon($request->code);
        $discountAmount = $coupon->calculateDiscount($cartTotal);

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil diterapkan!',
            'discount_percentage' => $coupon->discount_percentage,
            'discount_amount' => $discountAmount,
            'final_total' => $cartTotal - $discountAmount,
        ]);
    }

    /**
     * Remove coupon from cart
     */
    public function removeCoupon()
    {
        CartHelper::removeCoupon();

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil dihapus!',
            'cart_total' => CartHelper::getCartTotal(),
        ]);
    }

    /**
     * Process checkout
     */
    public function checkout(Request $request)
    {
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
            if ($coupon && $coupon->isValid()) {
                $discountAmount = $coupon->calculateDiscount($cartTotal);
                $coupon->markAsUsed();
            }
        }

        $finalTotal = $cartTotal - $discountAmount;

        // Here you would normally:
        // 1. Create order record
        // 2. Process payment
        // 3. Send confirmation email
        // For now, we'll just clear the cart

        CartHelper::clearCart();

        return redirect()->route('cart.index')->with('success', 'Pesanan berhasil! Total: Rp ' . number_format($finalTotal, 0, ',', '.'));
    }
}
