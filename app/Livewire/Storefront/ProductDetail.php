<?php

namespace App\Livewire\Storefront;

use App\Models\Product;
use App\Models\Review;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.storefront')]
class ProductDetail extends Component
{
    public Product $product;
    public int $qty = 1;
    public bool $inWishlist = false;

    public function mount(string $slug)
    {
        $this->product = Product::where('slug', $slug)->active()->firstOrFail();

        // Increment view count
        $this->product->increment('view_count');

        if (auth()->check()) {
            $user = auth()->user();
            if ($user->wishlist) {
                $this->inWishlist = $user->wishlist->hasProduct((string) $this->product->_id);
            }
        }
    }

    public function incrementQty()
    {
        if ($this->qty < min($this->product->stock, $this->product->max_order ?? 50)) {
            $this->qty++;
        }
    }

    public function decrementQty()
    {
        if ($this->qty > ($this->product->min_order ?? 1)) {
            $this->qty--;
        }
    }

    public function addToCart()
    {
        if (! auth()->check()) {
            return $this->redirect(route('login'), navigate: true);
        }

        $user = auth()->user();
        $cart = $user->cart ?? $user->cart()->create(['items' => []]);

        $cart->addItem((string) $this->product->_id, $this->qty);
        $cart->save();

        $this->dispatch('toast', message: "{$this->product->name} ditambahkan ke keranjang");
        $this->dispatch('cart-updated');
    }

    public function toggleWishlist()
    {
        if (! auth()->check()) {
            return $this->redirect(route('login'), navigate: true);
        }

        $user = auth()->user();
        $wishlist = $user->wishlist ?? $user->wishlist()->create(['product_ids' => []]);
        
        $added = $wishlist->toggleProduct((string) $this->product->_id);
        $wishlist->save();

        $this->inWishlist = $added;
        $this->dispatch('wishlist-updated');

        $this->dispatch('toast', message: $added ? 'Produk disimpan ke Wishlist' : 'Produk dihapus dari Wishlist');
    }

    public function render()
    {
        $reviews = Review::where('product_id', (string) $this->product->_id)
            ->approved()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $reviewSummary = Review::summaryForProduct((string) $this->product->_id);

        $relatedProducts = Product::active()
            ->inStock()
            ->where('category_id', $this->product->category_id)
            ->where('_id', '!=', $this->product->_id)
            ->limit(4)
            ->get();

        return view('livewire.storefront.product-detail', [
            'reviews'       => $reviews,
            'reviewSummary' => $reviewSummary,
            'relatedProducts' => $relatedProducts,
        ])
        ->title($this->product->name . ' - Koperasi Sembako');
    }
}
