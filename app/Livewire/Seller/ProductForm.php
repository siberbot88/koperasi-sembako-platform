<?php

namespace App\Livewire\Seller;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Str;

#[Layout('layouts.seller')]
#[Title('Tambah Produk')]
class ProductForm extends Component
{
    use WithFileUploads;

    public ?string $productId = null;

    #[Validate('required|string|max:200')]
    public string $name = '';

    #[Validate('required|string|max:20')]
    public string $sku = '';

    #[Validate('required|string')]
    public string $categoryId = '';

    #[Validate('nullable|string|max:2000')]
    public string $description = '';

    #[Validate('required|string|in:kg,liter,pcs,pack,sachet,botol')]
    public string $unit = 'pack';

    #[Validate('required|integer|min:0')]
    public int $weightGrams = 0;

    #[Validate('required|integer|min:0')]
    public int $basePrice = 0;

    #[Validate('nullable|integer|min:0')]
    public ?int $discountPrice = null;

    #[Validate('nullable|date')]
    public ?string $discountStart = null;

    #[Validate('nullable|date')]
    public ?string $discountEnd = null;

    #[Validate('required|integer|min:0')]
    public int $stock = 0;

    #[Validate('integer|min:1')]
    public int $minOrder = 1;

    #[Validate('integer|min:1')]
    public int $maxOrder = 50;

    #[Validate('required|in:active,draft')]
    public string $status = 'active';

    #[Validate('nullable|image|max:2048')]
    public $thumbnail;

    public ?string $existingThumbnail = null;

    public function mount(?string $id = null)
    {
        if ($id) {
            $user = auth()->user();
            $product = Product::where('_id', $id)
                ->where('store_id', (string) $user->store->_id)
                ->firstOrFail();

            $this->productId = $id;
            $this->name = $product->name;
            $this->sku = $product->sku;
            $this->categoryId = $product->category_id ?? '';
            $this->description = $product->description ?? '';
            $this->unit = $product->unit ?? 'pack';
            $this->weightGrams = $product->weight_grams ?? 0;
            $this->basePrice = $product->base_price ?? 0;
            $this->discountPrice = $product->discount_price;
            $this->discountStart = $product->discount_start?->format('Y-m-d');
            $this->discountEnd = $product->discount_end?->format('Y-m-d');
            $this->stock = $product->stock ?? 0;
            $this->minOrder = $product->min_order ?? 1;
            $this->maxOrder = $product->max_order ?? 50;
            $this->status = $product->status ?? 'active';
            $this->existingThumbnail = $product->thumbnail;
        }
    }

    public function save()
    {
        $this->validate();

        $user = auth()->user();
        $store = $user->store;

        $slug = Str::slug($this->name);

        // Handle unique slug
        $slugQuery = Product::where('slug', $slug);
        if ($this->productId) {
            $slugQuery->where('_id', '!=', $this->productId);
        }
        if ($slugQuery->exists()) {
            $slug .= '-' . Str::random(4);
        }

        // Handle thumbnail upload
        $thumbnailPath = $this->existingThumbnail;
        if ($this->thumbnail) {
            $thumbnailPath = $this->thumbnail->store('products', 'public');
        }

        $data = [
            'name' => $this->name,
            'slug' => $slug,
            'sku' => $this->sku,
            'category_id' => $this->categoryId,
            'store_id' => (string) $store->_id,
            'description' => $this->description ?: null,
            'unit' => $this->unit,
            'weight_grams' => $this->weightGrams,
            'base_price' => $this->basePrice,
            'discount_price' => $this->discountPrice ?: null,
            'discount_start' => $this->discountStart ? \Carbon\Carbon::parse($this->discountStart) : null,
            'discount_end' => $this->discountEnd ? \Carbon\Carbon::parse($this->discountEnd) : null,
            'stock' => $this->stock,
            'min_order' => $this->minOrder,
            'max_order' => $this->maxOrder,
            'status' => $this->status,
            'thumbnail' => $thumbnailPath,
            'images' => [],
            'specifications' => [],
            'tags' => [],
        ];

        if ($this->productId) {
            $product = Product::where('_id', $this->productId)
                ->where('store_id', (string) $store->_id)
                ->firstOrFail();
            $product->update($data);
            $message = 'Produk berhasil diperbarui';
        } else {
            $data['sold_count'] = 0;
            $data['view_count'] = 0;
            Product::create($data);
            $message = 'Produk berhasil ditambahkan';
        }

        $this->dispatch('toast', message: $message);
        return $this->redirect(route('seller.products'), navigate: true);
    }

    public function render()
    {
        $categories = Category::active()->ordered()->get();

        return view('livewire.seller.product-form', [
            'categories' => $categories,
        ]);
    }
}
