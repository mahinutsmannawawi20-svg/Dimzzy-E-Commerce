<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Helpers\CouponHelper;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Generate coupon after game
     */
    public function generate(Request $request)
    {
        $request->validate([
            'game_type' => 'required|in:pingpong,snake',
            'score' => 'required|integer|min:1000',
        ]);

        // Check if score is sufficient
        if ($request->score < 1000) {
            return response()->json([
                'success' => false,
                'message' => 'Score minimal 1000 untuk mendapatkan kupon!'
            ], 400);
        }

        // Check daily limit (max 3 coupons per day per session)
        $sessionCoupons = CouponHelper::getMyCoupons();
        $todayCoupons = Coupon::whereIn('code', $sessionCoupons)
                             ->whereDate('created_at', today())
                             ->count();

        if ($todayCoupons >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah mendapatkan 3 kupon hari ini! Coba lagi besok ya 😊'
            ], 400);
        }

        // Calculate discount percentage
        $discountPercentage = Coupon::calculateDiscountPercentage($request->score);

        // Generate unique code
        $code = Coupon::generateCode();

        // Create coupon
        $coupon = Coupon::create([
            'code' => $code,
            'player_name' => 'Session User', // Default name for session users
            'game_type' => $request->game_type,
            'score' => $request->score,
            'discount_percentage' => $discountPercentage,
            'min_purchase' => 10000,
            'expired_at' => Carbon::now()->addDays(7),
        ]);

        // Add coupon to session
        CouponHelper::addCoupon($coupon->code);

        return response()->json([
            'success' => true,
            'message' => 'Selamat! Kamu mendapatkan kupon diskon!',
            'coupon' => [
                'code' => $coupon->code,
                'discount_percentage' => $coupon->discount_percentage,
                'expired_at' => $coupon->expired_at->format('d M Y'),
                'min_purchase' => number_format((float)$coupon->min_purchase, 0, ',', '.'),
            ]
        ]);
    }

    /**
     * Display user's coupons from session
     */
    public function myCoupons(Request $request)
    {
        // Get coupon codes from session
        $couponCodes = CouponHelper::getMyCoupons();
        
        // Get actual coupon data from database
        $coupons = Coupon::whereIn('code', $couponCodes)
                        ->orderBy('created_at', 'desc')
                        ->get();

        $activeCoupons = $coupons->filter(fn($c) => $c->status === 'active');
        $usedCoupons = $coupons->filter(fn($c) => $c->status === 'used');
        $expiredCoupons = $coupons->filter(fn($c) => $c->status === 'expired');

        return view('coupons.index', compact('coupons', 'activeCoupons', 'usedCoupons', 'expiredCoupons'));
    }

    /**
     * Validate coupon code
     */
    public function validate(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'cart_total' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

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

        if ($request->cart_total < $coupon->min_purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal pembelian Rp ' . number_format((float)$coupon->min_purchase, 0, ',', '.') . ' untuk menggunakan kupon ini!'
            ], 400);
        }

        $discountAmount = $coupon->calculateDiscount($request->cart_total);

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil diterapkan!',
            'coupon' => [
                'code' => $coupon->code,
                'discount_percentage' => $coupon->discount_percentage,
                'discount_amount' => $discountAmount,
                'final_total' => $request->cart_total - $discountAmount,
            ]
        ]);
    }

    /**
     * Apply coupon (mark as used)
     */
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Kupon tidak valid!'
            ], 400);
        }

        $coupon->markAsUsed();

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil digunakan!'
        ]);
    }
}
