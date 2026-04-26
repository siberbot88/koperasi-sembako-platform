<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Coupon extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'coupons';

    protected $fillable = [
        'store_id',
        'code',
        'type',             // percentage | fixed
        'value',            // percentage (0-100) or fixed amount
        'min_order_amount',
        'max_discount',     // cap for percentage type
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
        'points_cost',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'integer',
            'min_order_amount' => 'integer',
            'max_discount' => 'integer',
            'usage_limit' => 'integer',
            'used_count' => 'integer',
            'valid_from' => 'datetime',
            'valid_until' => 'datetime',
            'is_active' => 'boolean',
            'points_cost' => 'integer',
        ];
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ── Validation ──

    public function isValid(int $orderAmount = 0): bool
    {
        if (! $this->is_active) return false;
        if ($this->valid_from && now()->lt($this->valid_from)) return false;
        if ($this->valid_until && now()->gt($this->valid_until)) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        if ($this->min_order_amount && $orderAmount < $this->min_order_amount) return false;

        return true;
    }

    /**
     * Calculate discount amount for a given order subtotal.
     */
    public function calculateDiscount(int $subtotal): int
    {
        if ($this->type === 'percentage') {
            $discount = (int) round($subtotal * $this->value / 100);
            if ($this->max_discount) {
                $discount = min($discount, $this->max_discount);
            }
            return $discount;
        }

        // fixed
        return min($this->value, $subtotal);
    }
}
