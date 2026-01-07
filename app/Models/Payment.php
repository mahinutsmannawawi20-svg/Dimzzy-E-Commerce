<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'trxid',
        'amount',
        'status',
        'qris_image_url',
        'response_data',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'response_data' => 'array',
    ];

    /**
     * Relationship to order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
