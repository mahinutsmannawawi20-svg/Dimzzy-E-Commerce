<?php

namespace App\Helpers;

use App\Models\Products;

class CartHelper
{
    /**
     * Get cart items from session
     */
    public static function getCart()
    {
        return session()->get('cart', []);
    }

    /**
     * Add product to cart
     */
    public static function addToCart($productId, $quantity = 1)
    {
        $cart = self::getCart();
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $product = Products::find($productId);
            if ($product) {
                $cart[$productId] = [
                    'id' => $product->id,
                    'nama_produk' => $product->nama_produk,
                    'harga' => $product->harga,
                    'foto' => $product->foto,
                    'quantity' => $quantity,
                ];
            }
        }
        
        session()->put('cart', $cart);
        return $cart;
    }

    /**
     * Update cart item quantity
     */
    public static function updateCart($productId, $quantity)
    {
        $cart = self::getCart();
        
        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }
        }
        
        session()->put('cart', $cart);
        return $cart;
    }

    /**
     * Remove item from cart
     */
    public static function removeFromCart($productId)
    {
        $cart = self::getCart();
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }
        
        session()->put('cart', $cart);
        return $cart;
    }

    /**
     * Get cart total
     */
    public static function getCartTotal()
    {
        $cart = self::getCart();
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
        }
        
        return $total;
    }

    /**
     * Get cart item count
     */
    public static function getCartCount()
    {
        $cart = self::getCart();
        $count = 0;
        
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        
        return $count;
    }

    /**
     * Clear cart
     */
    public static function clearCart()
    {
        session()->forget('cart');
        session()->forget('applied_coupon');
    }

    /**
     * Apply coupon to cart
     */
    public static function applyCoupon($couponCode)
    {
        session()->put('applied_coupon', $couponCode);
    }

    /**
     * Get applied coupon
     */
    public static function getAppliedCoupon()
    {
        return session()->get('applied_coupon');
    }

    /**
     * Remove applied coupon
     */
    public static function removeCoupon()
    {
        session()->forget('applied_coupon');
    }
}
