<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Review extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'reviews';

    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'rating',             // 1-5
        'comment',
        'images',             // array of uploaded image paths
        'seller_reply',       // seller response text
        'seller_replied_at',  // datetime of seller reply
        'is_verified_buyer',  // true if linked to a completed order
        'is_approved',        // true after passing moderation
        'helpful_count',      // number of "helpful" votes
    ];

    protected function casts(): array
    {
        return [
            'rating'           => 'integer',
            'images'           => 'array',
            'is_verified_buyer'=> 'boolean',
            'is_approved'      => 'boolean',
            'helpful_count'    => 'integer',
            'seller_replied_at'=> 'datetime',
        ];
    }

    // ── Relationships ──

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // ── Scopes ──

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeVerifiedBuyers($query)
    {
        return $query->where('is_verified_buyer', true);
    }

    public function scopeByRating($query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    // ── Static Helpers ──

    /**
     * Calculate rating summary for a given product_id.
     * Returns: [ 'average' => 4.2, 'total' => 23, 'distribution' => [5=>10, 4=>8, 3=>3, 2=>1, 1=>1] ]
     */
    public static function summaryForProduct(string $productId): array
    {
        $reviews = static::where('product_id', $productId)
            ->approved()
            ->get(['rating']);

        if ($reviews->isEmpty()) {
            return [
                'average'      => 0,
                'total'        => 0,
                'distribution' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0],
            ];
        }

        $total = $reviews->count();
        $distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

        foreach ($reviews as $r) {
            $star = (int) $r->rating;
            if (isset($distribution[$star])) {
                $distribution[$star]++;
            }
        }

        $average = round($reviews->avg('rating'), 1);

        return compact('average', 'total', 'distribution');
    }

    /**
     * Check if a user has already reviewed a specific product for a specific order.
     */
    public static function hasReviewed(string $userId, string $productId, string $orderId): bool
    {
        return static::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where('order_id', $orderId)
            ->exists();
    }
}
