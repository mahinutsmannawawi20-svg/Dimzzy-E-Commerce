<?php

namespace App\Helpers;

class CouponHelper
{
    /**
     * Get all coupon codes from session
     */
    public static function getMyCoupons()
    {
        return session()->get('my_coupons', []);
    }

    /**
     * Add coupon code to session
     */
    public static function addCoupon($couponCode)
    {
        $coupons = self::getMyCoupons();
        
        if (!in_array($couponCode, $coupons)) {
            $coupons[] = $couponCode;
            session()->put('my_coupons', $coupons);
        }
        
        return $coupons;
    }

    /**
     * Remove coupon code from session
     */
    public static function removeCoupon($couponCode)
    {
        $coupons = self::getMyCoupons();
        
        $key = array_search($couponCode, $coupons);
        if ($key !== false) {
            unset($coupons[$key]);
            $coupons = array_values($coupons); // Re-index array
            session()->put('my_coupons', $coupons);
        }
        
        return $coupons;
    }

    /**
     * Get coupon count
     */
    public static function getCouponCount()
    {
        return count(self::getMyCoupons());
    }

    /**
     * Clear all coupons from session
     */
    public static function clearCoupons()
    {
        session()->forget('my_coupons');
    }

    /**
     * Check if coupon code exists in session
     */
    public static function hasCoupon($couponCode)
    {
        return in_array($couponCode, self::getMyCoupons());
    }
}
