<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Store extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'stores';

    protected $fillable = [
        'user_id',
        'seller_id',
        'name',
        'slug',
        'tagline',
        'description',
        'logo',
        'banner',
        'phone',
        'email',
        'whatsapp',
        'address',
        'city',
        'province',
        'postal_code',
        'operational_hours',
        'is_active',
        'min_order',
        'free_shipping_min',
        'facebook',
        'instagram',
        'twitter',
        'tiktok',
        'website',
        'return_policy',
        'shipping_policy',
        'terms_conditions',
    ];

    protected function casts(): array
    {
        return [
            'operational_hours' => 'array',
            'is_active' => 'boolean',
            'min_order' => 'integer',
            'free_shipping_min' => 'integer',
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
