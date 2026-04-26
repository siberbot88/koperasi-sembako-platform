<?php

namespace App\Livewire\Storefront\Partials;

use Livewire\Component;
use Livewire\Attributes\On;

class CartBadge extends Component
{
    #[On('cart-updated')]
    public function render()
    {
        $cartCount = auth()->check() ? (auth()->user()->cart?->item_count ?? 0) : 0;
        
        return view('livewire.storefront.partials.cart-badge', [
            'cartCount' => $cartCount
        ]);
    }
}
