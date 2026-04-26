<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',         // customer | seller | admin
        'avatar',
        'addresses',    // embedded array of { label, recipient, phone, address, city, postal_code, is_default }
        'is_active',
        'points_balance',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'addresses' => 'array',
            'is_active' => 'boolean',
            'points_balance' => 'integer',
        ];
    }

    // ── Relationships ──

    public function store()
    {
        return $this->hasOne(Store::class, 'seller_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'user_id');
    }

    public function wishlist()
    {
        return $this->hasOne(Wishlist::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    // ── Helpers ──

    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function defaultAddress(): ?array
    {
        if (empty($this->addresses)) {
            return null;
        }

        return collect($this->addresses)->firstWhere('is_default', true)
            ?? $this->addresses[0]
            ?? null;
    }
}
