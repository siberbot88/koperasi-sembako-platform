<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable = [
        'sku',
        'name',
        'slug',
        'category_id',
        'store_id',
        'description',
        'unit',             // kg, liter, pcs, pack, sachet
        'weight_grams',
        'base_price',
        'discount_price',   // null = no discount
        'discount_start',
        'discount_end',
        'stock',
        'min_order',
        'max_order',
        'images',           // array of image paths
        'thumbnail',        // primary image path
        'specifications',   // embedded: [{ label, value }]
        'tags',             // array: ['promo', 'best-seller']
        'status',           // active | draft | archived
        'sold_count',
        'view_count',
    ];

    protected function casts(): array
    {
        return [
            'base_price' => 'integer',
            'discount_price' => 'integer',
            'discount_start' => 'datetime',
            'discount_end' => 'datetime',
            'stock' => 'integer',
            'min_order' => 'integer',
            'max_order' => 'integer',
            'images' => 'array',
            'specifications' => 'array',
            'tags' => 'array',
            'sold_count' => 'integer',
            'view_count' => 'integer',
            'weight_grams' => 'integer',
        ];
    }

    // ── Relationships ──

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    // ── Scopes ──

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch($query, string $keyword)
    {
        return $query->where('name', 'like', '%' . $keyword . '%');
    }

    // ── Accessors ──

    public function getEffectivePriceAttribute(): int
    {
        if (
            $this->discount_price
            && $this->discount_start
            && $this->discount_end
            && now()->between($this->discount_start, $this->discount_end)
        ) {
            return $this->discount_price;
        }

        return $this->base_price;
    }

    public function getIsOnSaleAttribute(): bool
    {
        return $this->effective_price < $this->base_price;
    }

    public function getDiscountPercentAttribute(): int
    {
        if (! $this->is_on_sale || $this->base_price === 0) {
            return 0;
        }

        return (int) round((1 - $this->discount_price / $this->base_price) * 100);
    }

    /**
     * Build a snapshot of this product for order embedding.
     */
    public function toOrderSnapshot(int $qty): array
    {
        return [
            'product_id'     => (string) $this->_id,
            'snapshot_name'  => $this->name,
            'snapshot_sku'   => $this->sku,
            'snapshot_category' => $this->category?->name ?? 'Lainnya',
            'snapshot_price' => $this->effective_price,
            'snapshot_image' => $this->thumbnail,
            'snapshot_unit'  => $this->unit,
            'qty'            => $qty,
            'subtotal'       => $this->effective_price * $qty,
        ];
    }
}
