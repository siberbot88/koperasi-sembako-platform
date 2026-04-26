<?php

namespace App\Livewire\Storefront;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.storefront')]
class OrderHistory extends Component
{
    public function render()
    {
        $orders = Order::where('user_id', (string) auth()->user()->_id)
            ->recent()
            ->paginate(10);

        return view('livewire.storefront.order-history', [
            'orders' => $orders,
        ])->title('Pesanan Saya - Koperasi Sembako');
    }
}
