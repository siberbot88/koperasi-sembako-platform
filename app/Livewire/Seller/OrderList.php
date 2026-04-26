<?php

namespace App\Livewire\Seller;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('layouts.seller')]
#[Title('Kelola Pesanan')]
class OrderList extends Component
{
    use WithPagination;

    #[Url(as: 'status')]
    public string $filterStatus = '';

    // Shipment Tracking State
    public bool   $showShipmentModal = false;
    public string $selectedOrderIdForShipment = '';
    public string $courier        = '';
    public string $trackingNumber = '';
    public int    $shippingCost   = 0;   // Rp — editable by seller

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updateOrderStatus(string $orderId, string $newStatus)
    {
        $user = auth()->user();
        $store = $user->store;

        $order = Order::where('_id', $orderId)
            ->forSeller((string) $store->_id)
            ->firstOrFail();

        if (! in_array($newStatus, Order::STATUSES)) {
            return;
        }

        if ($newStatus === Order::STATUS_COMPLETED && $order->status !== Order::STATUS_COMPLETED) {
            $user = $order->user;
            if ($user) {
                // Award 1 point per Rp 1.000 spent (rounded down)
                $pointsAwarded = floor(($order->total_amount ?? 0) / 1000);
                
                if ($pointsAwarded > 0) {
                    $user->increment('points_balance', $pointsAwarded);
                    $order->points_awarded = (int) $pointsAwarded;
                    $order->completed_at   = now();
                }
            }
        }

        $order->pushStatusHistory($newStatus);
        $order->save();

        $this->dispatch('toast', message: "Status pesanan diubah ke: " . ucfirst($newStatus));
    }

    public function openShipmentModal(string $orderId)
    {
        $order = Order::findOrFail($orderId);
        $this->selectedOrderIdForShipment = $orderId;
        
        // Pre-fill from order if customer already chose a courier
        $this->courier = $order->shipment['courier'] ?? '';
        $this->shippingCost = $order->shipment['shipping_cost'] ?? 0;

        if ($this->courier) {
            $this->trackingNumber = $this->generateTrackingNumber($this->courier);
        } else {
            $this->trackingNumber = '';
        }

        $this->showShipmentModal = true;
    }

    /**
     * Auto-regenerate tracking number AND populate base shipping rate
     * whenever courier changes.
     */
    public function updatedCourier(): void
    {
        if ($this->courier && isset(Order::COURIERS[$this->courier])) {
            $this->trackingNumber = $this->generateTrackingNumber($this->courier);
            $this->shippingCost   = Order::COURIERS[$this->courier]['base_rate'];
        } else {
            $this->trackingNumber = '';
            $this->shippingCost   = 0;
        }
    }

    /**
     * Generate a realistic-looking tracking number for the given courier.
     * Format: {PREFIX}{RANDOM_CHARS}{DATE_PART}
     */
    private function generateTrackingNumber(string $courier): string
    {
        $config = Order::COURIERS[$courier] ?? ['prefix' => 'PKG', 'length' => 12, 'chars' => 'NUM'];

        $prefix    = $config['prefix'];
        $totalLen  = $config['length'];
        $fillLen   = $totalLen - strlen($prefix);
        $datePart  = now()->format('dmy'); // e.g. 250426
        $remaining = max(0, $fillLen - strlen($datePart));

        if ($config['chars'] === 'NUM') {
            $random = str_pad((string) random_int(0, (int) str_repeat('9', $remaining)), $remaining, '0', STR_PAD_LEFT);
        } else {
            $pool   = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            $random = '';
            for ($i = 0; $i < $remaining; $i++) {
                $random .= $pool[random_int(0, strlen($pool) - 1)];
            }
        }

        return strtoupper($prefix . $random . $datePart);
    }

    public function closeShipmentModal()
    {
        $this->showShipmentModal = false;
        $this->selectedOrderIdForShipment = '';
    }

    public function processShipment()
    {
        $this->validate([
            'courier'       => 'required|string',
            'trackingNumber'=> 'required|string|min:6|max:30',
            'shippingCost'  => 'required|integer|min:0|max:500000',
        ], [
            'courier.required'        => 'Pilih kurir terlebih dahulu.',
            'trackingNumber.required' => 'Nomor resi tidak boleh kosong.',
            'shippingCost.min'        => 'Biaya ongkir tidak boleh negatif.',
        ]);

        // Ensure courier is from our approved list
        if (! array_key_exists($this->courier, Order::COURIERS)) {
            $this->addError('courier', 'Kurir tidak valid.');
            return;
        }

        $user  = auth()->user();
        $store = $user->store;

        $order = Order::where('_id', $this->selectedOrderIdForShipment)
            ->forSeller((string) $store->_id)
            ->firstOrFail();

        $order->shipment = [
            'courier'         => $this->courier,
            'tracking_number' => $this->trackingNumber,
            'shipping_cost'   => $this->shippingCost,
            'tracking_events' => [
                [
                    'status'    => 'Paket dikirim oleh penjual melalui ' . $this->courier,
                    'location'  => $store->city ?? 'Toko',
                    'timestamp' => now()->toISOString(),
                ]
            ]
        ];

        // Update shipping cost on the order total
        $order->shipping_cost  = $this->shippingCost;
        $order->total_amount   = ($order->subtotal ?? 0)
            - ($order->discount_amount ?? 0)
            + $this->shippingCost;

        $order->pushStatusHistory(
            Order::STATUS_SHIPPED,
            'Pesanan dikirim via ' . $this->courier . ' (' . $this->trackingNumber . ') | Ongkir: Rp ' . number_format($this->shippingCost, 0, ',', '.')
        );
        $order->save();

        $this->closeShipmentModal();
        $this->dispatch('toast', message: "Pesanan dikirim via {$this->courier} — Resi: {$this->trackingNumber}");
    }

    public function render()
    {
        $user = auth()->user();
        $store = $user->store;

        $query = Order::forSeller((string) $store->_id);

        if ($this->filterStatus) {
            $query->byStatus($this->filterStatus);
        }

        $orders = $query->recent()->paginate(15);

        return view('livewire.seller.order-list', [
            'orders' => $orders,
        ]);
    }
}
