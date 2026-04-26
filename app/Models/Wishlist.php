<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Wishlist extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'wishlists';

    protected $fillable = [
        'user_id',
        'product_ids',  // array of product ObjectIds
    ];

    protected function casts(): array
    {
        return [
            'product_ids' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function toggleProduct(string $productId): bool
    {
        $ids = collect($this->product_ids ?? []);

        if ($ids->contains($productId)) {
            $ids = $ids->reject(fn ($id) => $id === $productId);
            $this->product_ids = $ids->values()->toArray();
            return false; // removed
        }

        $ids->push($productId);
        $this->product_ids = $ids->values()->toArray();
        return true; // added
    }

    public function hasProduct(string $productId): bool
    {
        return in_array($productId, $this->product_ids ?? []);
    }
}
