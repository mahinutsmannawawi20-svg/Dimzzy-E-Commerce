<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\WishlistHelper;
use App\Helpers\CartHelper;
use App\Models\Products;

class WishlistController extends Controller
{
    /**
     * Display wishlist page
     */
    public function index()
    {
        $wishlist = WishlistHelper::getWishlist();
        return view('wishlist', compact('wishlist'));
    }

    /**
     * Add product to wishlist
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        WishlistHelper::addToWishlist($request->product_id);

        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke wishlist! 💖',
            'wishlist_count' => WishlistHelper::getWishlistCount(),
            'in_wishlist' => true,
        ]);
    }

    /**
     * Remove item from wishlist
     */
    public function remove($productId)
    {
        WishlistHelper::removeFromWishlist($productId);

        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari wishlist!',
            'wishlist_count' => WishlistHelper::getWishlistCount(),
            'in_wishlist' => false,
        ]);
    }

    /**
     * Toggle product in wishlist
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = WishlistHelper::toggleWishlist($request->product_id);
        $inWishlist = WishlistHelper::isInWishlist($request->product_id);

        return response()->json([
            'success' => true,
            'message' => $inWishlist ? 'Ditambahkan ke wishlist! 💖' : 'Dihapus dari wishlist!',
            'wishlist_count' => WishlistHelper::getWishlistCount(),
            'in_wishlist' => $inWishlist,
        ]);
    }

    /**
     * Move wishlist item to cart
     */
    public function moveToCart($productId)
    {
        if (!WishlistHelper::isInWishlist($productId)) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ada di wishlist!',
            ], 404);
        }

        // Add to cart
        CartHelper::addToCart($productId, 1);
        
        // Remove from wishlist
        WishlistHelper::removeFromWishlist($productId);

        return response()->json([
            'success' => true,
            'message' => 'Produk dipindahkan ke keranjang! 🛒',
            'wishlist_count' => WishlistHelper::getWishlistCount(),
            'cart_count' => CartHelper::getCartCount(),
        ]);
    }

    /**
     * Clear all wishlist items
     */
    public function clear()
    {
        WishlistHelper::clearWishlist();

        return response()->json([
            'success' => true,
            'message' => 'Wishlist dikosongkan!',
        ]);
    }
}
