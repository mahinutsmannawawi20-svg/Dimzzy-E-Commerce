<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Helpers\WishlistHelper;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::all();
        $wishlistCount = WishlistHelper::getWishlistCount();
        
        return view('products', compact('products', 'wishlistCount'));
    }
}