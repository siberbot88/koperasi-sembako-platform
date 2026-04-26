<?php

namespace App\Livewire\Storefront;

use App\Models\Cart;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.storefront')]
#[Title('Keranjang Belanja - Koperasi Sembako')]
class CartPage extends Component
{
    public function mount()
    {
        $user = auth()->user();
        abort_if($user && $user->isSeller(), 403, 'Akun Seller tidak dapat melakukan pembelian. Silakan gunakan akun Customer.');
    }

    public function updateQty(string $productId, int $qty)
    {
        $cart = $this->getCart();
        if (! $cart) return;

        $product = Product::find($productId);
        if (! $product) return;

        $qty = max(1, min($qty, $product->stock));
        $cart->addItem($productId, $qty);
        $cart->save();

        $this->dispatch('cart-updated');
    }

    public function removeItem(string $productId)
    {
        $cart = $this->getCart();
        if (! $cart) return;

        $cart->removeItem($productId);
        $cart->save();

        $this->dispatch('toast', message: 'Produk dihapus dari keranjang');
        $this->dispatch('cart-updated');
    }

    public function clearCart()
    {
        $cart = $this->getCart();
        if (! $cart) return;

        $cart->items = [];
        $cart->save();

        $this->dispatch('toast', message: 'Keranjang dikosongkan');
        $this->dispatch('cart-updated');
    }

    protected function getCart(): ?Cart
    {
        if (! auth()->check()) return null;
        return auth()->user()->cart;
    }

    public function render()
    {
        $cart = $this->getCart();
        $cartItems = collect();
        $subtotal = 0;

        if ($cart && ! empty($cart->items)) {
            $productIds = collect($cart->items)->pluck('product_id')->toArray();
            $products = Product::whereIn('_id', $productIds)->get()->keyBy(fn($p) => (string) $p->_id);

            $cartItems = collect($cart->items)->map(function ($item) use ($products, &$subtotal) {
                $product = $products[$item['product_id']] ?? null;
                if (! $product) return null;

                $itemSubtotal = $product->effective_price * $item['qty'];
                $subtotal += $itemSubtotal;

                return [
                    'product' => $product,
                    'qty' => $item['qty'],
                    'subtotal' => $itemSubtotal,
                ];
            })->filter();
        }

        return view('livewire.storefront.cart-page', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
        ]);
    }
}
