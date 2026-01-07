<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'player_name',
        'game_type',
        'score',
        'discount_percentage',
        'min_purchase',
        'is_used',
        'used_at',
        'expired_at',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
        'expired_at' => 'datetime',
        'min_purchase' => 'decimal:2',
    ];

    /**
     * Scope for active coupons (not used and not expired)
     */
    public function scopeActive($query)
    {
        return $query->where('is_used', false)
                    ->where('expired_at', '>', now());
    }

    /**
     * Scope for player's coupons
     */
    public function scopeForPlayer($query, $playerName)
    {
        return $query->where('player_name', $playerName);
    }

    /**
     * Scope for today's coupons
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Check if coupon is valid for use
     */
    public function isValid()
    {
        return !$this->is_used && $this->expired_at > now();
    }

    /**
     * Check if coupon can be applied to given cart total
     */
    public function canApplyTo($cartTotal)
    {
        return $this->isValid() && $cartTotal >= $this->min_purchase;
    }

    /**
     * Calculate discount amount for given total
     */
    public function calculateDiscount($total)
    {
        return ($total * $this->discount_percentage) / 100;
    }

    /**
     * Mark coupon as used
     */
    public function markAsUsed()
    {
        $this->update([
            'is_used' => true,
            'used_at' => now(),
        ]);
    }

    /**
     * Get formatted discount display
     */
    public function getFormattedDiscountAttribute()
    {
        return $this->discount_percentage . '%';
    }

    /**
     * Get status badge
     */
    public function getStatusAttribute()
    {
        if ($this->is_used) {
            return 'used';
        }
        if ($this->expired_at < now()) {
            return 'expired';
        }
        return 'active';
    }

    /**
     * Generate unique coupon code
     */
    public static function generateCode()
    {
        do {
            $code = 'GAME-' . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    /**
     * Calculate discount percentage from score
     */
    public static function calculateDiscountPercentage($score)
    {
        // Score / 200 = discount %
        // Min: 1000 score = 5%
        // Max: 45%
        $percentage = floor($score / 200);
        return min($percentage, 45);
    }
}
