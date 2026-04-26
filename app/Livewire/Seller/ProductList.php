<?php

namespace App\Livewire\Seller;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('layouts.seller')]
#[Title('Kelola Produk')]
class ProductList extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function deleteProduct(string $id)
    {
        $user = auth()->user();
        $product = Product::where('_id', $id)
            ->where('store_id', (string) $user->store->_id)
            ->firstOrFail();

        $product->delete();

        $this->dispatch('toast', message: 'Produk berhasil dihapus');
    }

    public function render()
    {
        $user = auth()->user();
        $store = $user->store;

        $query = Product::where('store_id', (string) $store->_id);

        if ($this->search) {
            $query->search($this->search);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('livewire.seller.product-list', [
            'products' => $products,
        ]);
    }
}
