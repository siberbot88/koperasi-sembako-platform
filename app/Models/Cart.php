<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Cart extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'carts';

    protected $fillable = [
        'user_id',
        'session_id',   // for guest carts
        'items',        // embedded: [{ product_id, qty, added_at }]
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
        ];
    }

    // ── Relationships ──

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ── Helpers ──

    /**
     * Add or update an item in the cart (increments qty if exists).
     */
    public function addItem(string $productId, int $qty): void
    {
        $items = collect($this->items ?? []);

        $existing = $items->firstWhere('product_id', $productId);

        if ($existing) {
            $items = $items->map(function ($item) use ($productId, $qty) {
                if ($item['product_id'] === $productId) {
                    $item['qty'] += $qty;
                }
                return $item;
            });
        } else {
            $items->push([
                'product_id' => $productId,
                'qty' => $qty,
                'added_at' => now()->toISOString(),
            ]);
        }

        $this->items = $items->values()->toArray();
    }

    /**
     * Set an item's qty to an exact value (used when updating from cart page).
     */
    public function setItem(string $productId, int $qty): void
    {
        $items = collect($this->items ?? []);

        $existing = $items->firstWhere('product_id', $productId);

        if ($existing) {
            $items = $items->map(function ($item) use ($productId, $qty) {
                if ($item['product_id'] === $productId) {
                    $item['qty'] = $qty;
                }
                return $item;
            });
        } else {
            $items->push([
                'product_id' => $productId,
                'qty' => $qty,
                'added_at' => now()->toISOString(),
            ]);
        }

        $this->items = $items->values()->toArray();
    }

    /**
     * Remove an item from the cart.
     */
    public function removeItem(string $productId): void
    {
        $items = collect($this->items ?? [])
            ->reject(fn ($item) => $item['product_id'] === $productId);

        $this->items = $items->values()->toArray();
    }

    /**
     * Get total number of unique items.
     */
    public function getItemCountAttribute(): int
    {
        return count($this->items ?? []);
    }
}
