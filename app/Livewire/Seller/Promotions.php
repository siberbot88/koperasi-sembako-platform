<?php

namespace App\Livewire\Seller;

use App\Models\Coupon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

#[Layout('layouts.seller')]
#[Title('Manajemen Promosi & Hadiah')]
class Promotions extends Component
{
    // Form fields
    #[Validate('required|string|max:20')]
    public string $code = '';

    #[Validate('required|in:fixed,percentage')]
    public string $type = 'fixed';

    #[Validate('required|integer|min:1')]
    public int $value = 0;

    #[Validate('required|integer|min:0')]
    public int $minOrder = 0;

    #[Validate('nullable|integer|min:0')]
    public ?int $maxDiscount = null;

    #[Validate('required|integer|min:0')]
    public int $usageLimit = 0; // 0 = unlimited

    #[Validate('required|integer|min:0')]
    public int $pointsCost = 0; // 0 = public coupon, >0 = reward template

    public string $couponType = 'public'; // 'public' | 'reward'

    #[Validate('nullable|date')]
    public ?string $validFrom = null;

    #[Validate('nullable|date')]
    public ?string $validUntil = null;

    public bool $isActive = true;

    public function save()
    {
        $this->validate();

        // If public coupon, force points_cost to 0
        if ($this->couponType === 'public') {
            $this->pointsCost = 0;
        } elseif ($this->pointsCost < 1) {
            $this->addError('pointsCost', 'Harga poin harus minimal 1.');
            return;
        }

        $user = auth()->user();
        $store = $user->store;

        Coupon::create([
            'store_id' => (string) $store->_id,
            'code' => strtoupper($this->code),
            'type' => $this->type,
            'value' => $this->value,
            'min_order_amount' => $this->minOrder,
            'max_discount' => $this->type === 'percentage' ? $this->maxDiscount : null,
            'usage_limit' => $this->usageLimit,
            'used_count' => 0,
            'points_cost' => $this->pointsCost,
            'valid_from' => $this->validFrom ? \Carbon\Carbon::parse($this->validFrom) : null,
            'valid_until' => $this->validUntil ? \Carbon\Carbon::parse($this->validUntil) : null,
            'is_active' => $this->isActive,
            // user_id is left null intentionally. Reward templates and global coupons must have null user_id.
        ]);

        $this->reset([
            'code', 'type', 'value', 'minOrder', 'maxDiscount', 'usageLimit', 'pointsCost', 'validFrom', 'validUntil', 'isActive', 'couponType'
        ]);

        // Create notification for all users if it's a public coupon (not reward)
        if ($this->couponType === 'public' && $this->isActive) {
            $users = \App\Models\User::where('role', 'customer')->get();
            foreach ($users as $user) {
                \App\Models\Notification::createForUser(
                    $user->_id,
                    \App\Models\Notification::TYPE_NEW_COUPON,
                    'Kupon Baru Tersedia!',
                    "Gunakan kode '{$this->code}' untuk diskon " . ($this->type === 'percentage' ? "{$this->value}%" : "Rp " . number_format($this->value, 0, ',', '.')),
                    route('products.index'),
                    ['coupon_code' => $this->code]
                );
            }
        }

        $this->dispatch('toast', message: 'Promo/Hadiah berhasil ditambahkan');
    }

    public function toggleStatus(string $id)
    {
        $coupon = Coupon::where('_id', $id)
            ->where('store_id', (string) auth()->user()->store->_id)
            ->firstOrFail();

        $coupon->update(['is_active' => !$coupon->is_active]);
        $this->dispatch('toast', message: 'Status diperbarui');
    }

    public function delete(string $id)
    {
        $coupon = Coupon::where('_id', $id)
            ->where('store_id', (string) auth()->user()->store->_id)
            ->firstOrFail();

        $coupon->delete();
        $this->dispatch('toast', message: 'Dihapus');
    }

    public function render()
    {
        $storeId = (string) auth()->user()->store->_id;
        
        // Exclude individually redeemed coupons (user_id is not null)
        $coupons = Coupon::where('store_id', $storeId)
            ->whereNull('user_id')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.seller.promotions', [
            'coupons' => $coupons,
        ]);
    }
}
