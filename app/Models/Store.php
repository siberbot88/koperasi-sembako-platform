<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Store extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'stores';

    protected $fillable = [
        'seller_id',
        'name',
        'slug',
        'description',
        'logo',
        'banner',
        'phone',
        'address',
        'city',
        'operational_hours',   // embedded: { open, close }
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'operational_hours' => 'array',
            'is_active' => 'boolean',
        ];
    }

    // ── Relationships ──

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'store_id');
    }

    public function banners()
    {
        return $this->hasMany(Banner::class, 'store_id');
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'store_id');
    }
}
