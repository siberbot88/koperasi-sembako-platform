<?php

namespace App\Livewire\Storefront;

use App\Models\Coupon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;

#[Layout('layouts.storefront')]
#[Title('Tukar Poin - Koperasi Sembako')]
class RewardsPage extends Component
{
    public function redeem(string $templateId)
    {
        $user = auth()->user();
        $template = Coupon::findOrFail($templateId);

        if (! $template->points_cost || $template->points_cost <= 0) {
            $this->dispatch('toast', message: 'Kupon ini tidak dapat ditukar dengan poin.', type: 'error');
            return;
        }

        $balance = $user->points_balance ?? 0;

        if ($balance < $template->points_cost) {
            $this->dispatch('toast', message: 'Poin Anda tidak cukup.', type: 'error');
            return;
        }

        // Deduct points
        $user->decrement('points_balance', $template->points_cost);

        // Generate unique coupon for this user based on template
        $uniqueCode = 'RW-' . strtoupper(Str::random(6));

        Coupon::create([
            'store_id' => $template->store_id,
            'code' => $uniqueCode,
            'type' => $template->type,
            'value' => $template->value,
            'min_order_amount' => $template->min_order_amount,
            'max_discount' => $template->max_discount,
            'usage_limit' => 1,
            'used_count' => 0,
            'valid_from' => now(),
            'valid_until' => now()->addDays(30), // Reward valid for 30 days
            'is_active' => true,
            'points_cost' => 0, // Generated coupon doesn't cost points
            'user_id' => (string) $user->_id,
        ]);

        $this->dispatch('toast', message: 'Berhasil menukar poin dengan Kupon!');
    }

    public function render()
    {
        $user = auth()->user();

        // Templates are active coupons with a points_cost > 0 and no specific user_id
        $templates = Coupon::where('is_active', true)
            ->where('points_cost', '>', 0)
            ->whereNull('user_id')
            ->get();

        // My Redeemed Coupons
        $myCoupons = Coupon::where('user_id', (string) $user->_id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.storefront.rewards-page', [
            'points' => $user->points_balance ?? 0,
            'templates' => $templates,
            'myCoupons' => $myCoupons,
        ]);
    }
}
