<?php

namespace App\Helpers;

use App\Models\Products;

class WishlistHelper
{
    /**
     * Get wishlist items from session
     */
    public static function getWishlist()
    {
        return session()->get('wishlist', []);
    }

    /**
     * Add product to wishlist
     */
    public static function addToWishlist($productId)
    {
        $wishlist = self::getWishlist();
        
        if (!isset($wishlist[$productId])) {
            $product = Products::find($productId);
            if ($product) {
                $wishlist[$productId] = [
                    'id' => $product->id,
                    'nama_produk' => $product->nama_produk,
                    'harga' => $product->harga,
                    'foto' => $product->foto,
                ];
            }
        }
        
        session()->put('wishlist', $wishlist);
        return $wishlist;
    }

    /**
     * Remove item from wishlist
     */
    public static function removeFromWishlist($productId)
    {
        $wishlist = self::getWishlist();
        
        if (isset($wishlist[$productId])) {
            unset($wishlist[$productId]);
        }
        
        session()->put('wishlist', $wishlist);
        return $wishlist;
    }

    /**
     * Check if product is in wishlist
     */
    public static function isInWishlist($productId)
    {
        $wishlist = self::getWishlist();
        return isset($wishlist[$productId]);
    }

    /**
     * Get wishlist item count
     */
    public static function getWishlistCount()
    {
        return count(self::getWishlist());
    }

    /**
     * Clear wishlist
     */
    public static function clearWishlist()
    {
        session()->forget('wishlist');
    }

    /**
     * Toggle product in wishlist (add if not exists, remove if exists)
     */
    public static function toggleWishlist($productId)
    {
        if (self::isInWishlist($productId)) {
            return self::removeFromWishlist($productId);
        } else {
            return self::addToWishlist($productId);
        }
    }
}
