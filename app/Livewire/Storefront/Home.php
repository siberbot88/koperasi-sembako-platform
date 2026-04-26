<?php

namespace App\Livewire\Storefront;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.storefront')]
#[Title('Koperasi Sembako - Belanja Kebutuhan Pokok Harian')]
class Home extends Component
{
    public function render()
    {
        $categories = Category::active()->topLevel()->ordered()->get();
        $bestSellers = Product::active()->inStock()->orderBy('sold_count', 'desc')->limit(8)->get();
        $latestProducts = Product::active()->inStock()->orderBy('created_at', 'desc')->limit(8)->get();
        $banners = Banner::active()->ordered()->get();

        return view('livewire.storefront.home', [
            'categories' => $categories,
            'bestSellers' => $bestSellers,
            'latestProducts' => $latestProducts,
            'banners' => $banners,
        ]);
    }
}
