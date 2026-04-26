<?php

namespace App\Livewire\Storefront;

use App\Models\Product;
use App\Models\Wishlist as WishlistModel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.storefront')]
#[Title('Wishlist - Koperasi Sembako')]
class WishlistPage extends Component
{
    public function toggleWishlist(string $productId)
    {
        $user = auth()->user();
        $wishlist = $user->wishlist ?? $user->wishlist()->create(['product_ids' => []]);

        $wishlist->toggleProduct($productId);
        $wishlist->save();

        $this->dispatch('toast', message: 'Wishlist diperbarui');
    }

    public function render()
    {
        $user = auth()->user();
        $wishlist = $user->wishlist;
        $products = collect();

        if ($wishlist && ! empty($wishlist->product_ids)) {
            $products = Product::whereIn('_id', $wishlist->product_ids)->active()->get();
        }

        return view('livewire.storefront.wishlist-page', [
            'products' => $products,
        ]);
    }
}
