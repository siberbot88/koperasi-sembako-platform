<?php

namespace App\Livewire\Storefront;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Coupon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

#[Layout('layouts.storefront')]
#[Title('Checkout - Koperasi Sembako')]
class Checkout extends Component
{
    // Shipping address
    #[Validate('required_if:fulfillmentType,delivery|nullable|string|max:100')]
    public string $recipient = '';

    #[Validate('required_if:fulfillmentType,delivery|nullable|string|max:20')]
    public string $phone = '';

    #[Validate('required_if:fulfillmentType,delivery|nullable|string|max:500')]
    public string $address = '';

    #[Validate('required_if:fulfillmentType,delivery|nullable|string|max:100')]
    public string $city = '';

    #[Validate('nullable|string|max:10')]
    public string $postalCode = '';

    #[Validate('required|in:pickup,delivery')]
    public string $fulfillmentType = 'pickup';

    #[Validate('nullable|string|max:500')]
    public string $notes = '';

    // Shipping Courier
    #[Validate('required_if:fulfillmentType,delivery|nullable|string')]
    public string $selectedCourier = '';
    public int $shippingCost = 0;

    // Coupon
    public string $couponCode = '';
    public ?array $appliedCoupon = null;
    public string $couponError = '';
    public int $discountAmount = 0;

    public function mount()
    {
        $user = auth()->user();
        abort_if($user->isSeller(), 403, 'Akun Seller tidak dapat melakukan pembelian. Silakan gunakan akun Customer.');

        $defaultAddr = $user->defaultAddress();

        if ($defaultAddr) {
            $this->recipient = $defaultAddr['recipient'] ?? $user->name;
            $this->phone = $defaultAddr['phone'] ?? $user->phone ?? '';
            $this->address = $defaultAddr['address'] ?? '';
            $this->city = $defaultAddr['city'] ?? '';
            $this->postalCode = $defaultAddr['postal_code'] ?? '';
        } else {
            $this->recipient = $user->name;
            $this->phone = $user->phone ?? '';
        }
    }

    public function applyCoupon()
    {
        $this->couponError = '';
        $this->appliedCoupon = null;
        $this->discountAmount = 0;

        if (empty($this->couponCode)) {
            $this->couponError = 'Masukkan kode kupon';
            return;
        }

        $coupon = Coupon::where('code', strtoupper($this->couponCode))->first();

        if (! $coupon) {
            $this->couponError = 'Kode kupon tidak ditemukan';
            return;
        }

        $user = auth()->user();
        if ($coupon->user_id && $coupon->user_id !== (string) $user->_id) {
            $this->couponError = 'Kupon ini eksklusif dan tidak berlaku untuk akun Anda';
            return;
        }

        $subtotal = $this->calculateSubtotal();

        if (! $coupon->isValid($subtotal)) {
            $this->couponError = 'Kupon tidak berlaku. Minimum belanja Rp ' . number_format($coupon->min_order_amount, 0, ',', '.');
            return;
        }

        $this->discountAmount = $coupon->calculateDiscount($subtotal);
        $this->appliedCoupon = [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
        ];

        $this->dispatch('toast', message: 'Kupon berhasil diterapkan');
    }

    public function removeCoupon()
    {
        $this->appliedCoupon = null;
        $this->discountAmount = 0;
        $this->couponCode = '';
        $this->couponError = '';
    }

    public function updatedSelectedCourier()
    {
        if ($this->selectedCourier && isset(Order::COURIERS[$this->selectedCourier])) {
            $this->shippingCost = Order::COURIERS[$this->selectedCourier]['base_rate'];
        } else {
            $this->shippingCost = 0;
        }
    }

    public function updatedFulfillmentType()
    {
        if ($this->fulfillmentType === 'pickup') {
            $this->selectedCourier = '';
            $this->shippingCost = 0;
        }
    }

    public function placeOrder()
    {
        $this->validate();

        $user = auth()->user();
        $cart = $user->cart;

        if (! $cart || empty($cart->items)) {
            $this->dispatch('toast', message: 'Keranjang kosong', type: 'error');
            return;
        }

        $productIds = collect($cart->items)->pluck('product_id')->toArray();
        $products = Product::whereIn('_id', $productIds)->get()->keyBy(fn($p) => (string) $p->_id);

        // Build order items with snapshot & validate stock
        $orderItems = [];
        $subtotal = 0;

        foreach ($cart->items as $item) {
            $product = $products[$item['product_id']] ?? null;
            if (! $product) continue;

            if ($product->stock < $item['qty']) {
                $this->dispatch('toast', message: "{$product->name} stok tidak mencukupi (tersisa {$product->stock})", type: 'error');
                return;
            }

            $snapshot = $product->toOrderSnapshot($item['qty']);
            $orderItems[] = $snapshot;
            $subtotal += $snapshot['subtotal'];
        }

        if (empty($orderItems)) {
            $this->dispatch('toast', message: 'Tidak ada item valid', type: 'error');
            return;
        }

        // Recalculate discount
        if ($this->appliedCoupon) {
            $coupon = Coupon::where('code', $this->appliedCoupon['code'])->first();
            if ($coupon && $coupon->isValid($subtotal)) {
                $this->discountAmount = $coupon->calculateDiscount($subtotal);
                $coupon->increment('used_count');
            } else {
                $this->discountAmount = 0;
                $this->appliedCoupon = null;
            }
        }

        $totalAmount = max(0, $subtotal - $this->discountAmount);

        // Decrement stock atomically
        foreach ($cart->items as $item) {
            $product = $products[$item['product_id']] ?? null;
            if (! $product) continue;

            $updated = Product::where('_id', $product->_id)
                ->where('stock', '>=', $item['qty'])
                ->decrement('stock', $item['qty']);

            if (! $updated) {
                $this->dispatch('toast', message: "{$product->name} stok habis saat proses checkout", type: 'error');
                return;
            }

            // Increment sold count
            Product::where('_id', $product->_id)->increment('sold_count', $item['qty']);
        }

        // Determine store_id from first product
        $firstProduct = $products->first();
        $storeId = $firstProduct?->store_id;

        // Create order
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => (string) $user->_id,
            'store_id' => $storeId,
            'items' => $orderItems,
            'shipping_address' => [
                'recipient' => $this->recipient,
                'phone' => $this->phone,
                'address' => $this->address,
                'city' => $this->city,
                'postal_code' => $this->postalCode,
            ],
            'fulfillment_type' => $this->fulfillmentType,
            'status' => Order::STATUS_PENDING,
            'subtotal' => $subtotal,
            'discount_amount' => $this->discountAmount,
            'shipping_cost' => $this->shippingCost,
            'total_amount' => $totalAmount + $this->shippingCost,
            'shipment' => $this->selectedCourier ? [
                'courier' => $this->selectedCourier,
                'shipping_cost' => $this->shippingCost,
            ] : null,
            'coupon_snapshot' => $this->appliedCoupon,
            'notes' => $this->notes ?: null,
            'status_history' => [
                [
                    'status' => Order::STATUS_PENDING,
                    'changed_at' => now()->toISOString(),
                    'note' => 'Pesanan dibuat',
                ],
            ],
        ]);

        // Clear cart
        $cart->items = [];
        $cart->save();

        $this->dispatch('cart-updated');
        $this->dispatch('toast', message: 'Pesanan berhasil dibuat!');

        return $this->redirect(route('orders.show', $order->order_number), navigate: true);
    }

    protected function calculateSubtotal(): int
    {
        $user = auth()->user();
        $cart = $user->cart;

        if (! $cart || empty($cart->items)) return 0;

        $productIds = collect($cart->items)->pluck('product_id')->toArray();
        $products = Product::whereIn('_id', $productIds)->get()->keyBy(fn($p) => (string) $p->_id);

        $subtotal = 0;
        foreach ($cart->items as $item) {
            $product = $products[$item['product_id']] ?? null;
            if ($product) {
                $subtotal += $product->effective_price * $item['qty'];
            }
        }

        return $subtotal;
    }

    public function render()
    {
        $user = auth()->user();
        $cart = $user->cart;
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

        $total = max(0, $subtotal - $this->discountAmount + $this->shippingCost);

        return view('livewire.storefront.checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'total' => $total,
            'shippingCost' => $this->shippingCost,
        ]);
    }
}
