<?php

namespace App\Livewire\Storefront;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.storefront')]
class OrderDetail extends Component
{
    public Order $order;

    public function mount(string $orderNumber)
    {
        $this->order = Order::where('order_number', $orderNumber)
            ->where('user_id', (string) auth()->user()->_id)
            ->firstOrFail();
    }

    public bool $showCancelModal = false;
    public string $cancelReason = '';

    public function openCancelModal()
    {
        if ($this->order->status !== 'pending') {
            $this->dispatch('toast', message: 'Hanya pesanan berstatus Menunggu Konfirmasi yang bisa dibatalkan langsung.', type: 'error');
            return;
        }
        $this->showCancelModal = true;
        $this->cancelReason = '';
    }

    public function closeCancelModal()
    {
        $this->showCancelModal = false;
    }

    public function processCancellation()
    {
        if ($this->order->status !== 'pending') {
            $this->dispatch('toast', message: 'Pesanan tidak bisa dibatalkan.', type: 'error');
            return;
        }

        $this->validate([
            'cancelReason' => 'required|string|max:200'
        ], [
            'cancelReason.required' => 'Pilih atau tulis alasan pembatalan.'
        ]);

        // 1. Ubah status pesanan
        $this->order->cancellation = [
            'requested_at' => now()->toISOString(),
            'reason' => $this->cancelReason,
            'status' => 'approved',
            'rejected_reason' => ''
        ];
        
        $this->order->pushStatusHistory(Order::STATUS_CANCELLED, 'Dibatalkan oleh pembeli: ' . $this->cancelReason);
        $this->order->save();

        // 2. Kembalikan stok produk (Restock)
        foreach ($this->order->items as $item) {
            $productId = $item['product_id'] ?? null;
            $qty = $item['qty'] ?? 0;

            if ($productId && $qty > 0) {
                Product::where('_id', $productId)->increment('stock', $qty);
                Product::where('_id', $productId)->decrement('sold_count', $qty);
            }
        }

        $this->closeCancelModal();
        $this->dispatch('toast', message: 'Pesanan berhasil dibatalkan dan stok telah dikembalikan.');
    }

    public function render()
    {
        return view('livewire.storefront.order-detail')
            ->title("Pesanan {$this->order->order_number} - Koperasi Sembako");
    }
}
