<?php

namespace App\Http\Controllers;

use App\Models\ScoreMinigame;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScoreMinigameController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'player_name' => 'required|string|max:100',
            'score' => 'required|integer',
            'game_type' => 'required|in:pingpong,snake',
        ]);

        // Save score
        ScoreMinigame::create([
            'player_name' => $request->player_name,
            'score' => $request->score
        ]);

        $response = [
            'status' => 'success',
            'coupon_generated' => false,
        ];

        // Check if eligible for coupon (score >= 1000)
        if ($request->score >= 1000) {
            // Check daily limit (max 3 coupons per day)
            $todayCoupons = Coupon::forPlayer($request->player_name)
                                 ->today()
                                 ->count();

            if ($todayCoupons < 3) {
                // Calculate discount percentage
                $discountPercentage = Coupon::calculateDiscountPercentage($request->score);

                // Generate unique code
                $code = Coupon::generateCode();

                // Create coupon
                $coupon = Coupon::create([
                    'code' => $code,
                    'player_name' => $request->player_name,
                    'game_type' => $request->game_type,
                    'score' => $request->score,
                    'discount_percentage' => $discountPercentage,
                    'min_purchase' => 10000,
                    'expired_at' => Carbon::now()->addDays(7),
                ]);

                $response['coupon_generated'] = true;
                $response['coupon'] = [
                    'code' => $coupon->code,
                    'discount_percentage' => $coupon->discount_percentage,
                    'expired_at' => $coupon->expired_at->format('d M Y'),
                    'min_purchase' => number_format($coupon->min_purchase, 0, ',', '.'),
                ];
            } else {
                $response['message'] = 'Kamu sudah mendapatkan 3 kupon hari ini! Coba lagi besok ya 😊';
            }
        }

        return response()->json($response);
    }
}
