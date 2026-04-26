<?php

namespace App\Livewire\Storefront;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('layouts.storefront')]
#[Title('Semua Produk - Koperasi Sembako')]
class ProductIndex extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'kategori')]
    public string $categorySlug = '';

    #[Url(as: 'urut')]
    public string $sortBy = 'terbaru';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedCategorySlug()
    {
        $this->resetPage();
    }

    public function setCategory(string $slug)
    {
        $this->categorySlug = $this->categorySlug === $slug ? '' : $slug;
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::active()->topLevel()->ordered()->get();

        $query = Product::active()->inStock();

        // Search
        if ($this->search) {
            $query->search($this->search);
        }

        // Category filter
        if ($this->categorySlug) {
            $category = Category::where('slug', $this->categorySlug)->first();
            if ($category) {
                $query->byCategory((string) $category->_id);
            }
        }

        // Sort
        $query = match ($this->sortBy) {
            'harga-rendah' => $query->orderBy('base_price', 'asc'),
            'harga-tinggi' => $query->orderBy('base_price', 'desc'),
            'terlaris'     => $query->orderBy('sold_count', 'desc'),
            default        => $query->orderBy('created_at', 'desc'),
        };

        $products = $query->paginate(12);

        return view('livewire.storefront.product-index', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
