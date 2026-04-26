<?php

namespace App\Livewire\Seller;

use App\Models\Review;
use App\Models\Store;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.seller')]
#[Title('Ulasan Pelanggan')]
class ReviewInsight extends Component
{
    use WithPagination;

    public string $filterRating = '';
    public string $replyText    = '';
    public string $replyTarget  = ''; // review _id

    public bool $showReplyModal = false;

    public function updatedFilterRating(): void
    {
        $this->resetPage();
    }

    public function openReplyModal(string $reviewId): void
    {
        $this->replyTarget  = $reviewId;
        $this->replyText    = '';
        $this->showReplyModal = true;
    }

    public function closeReplyModal(): void
    {
        $this->showReplyModal = false;
        $this->replyTarget    = '';
        $this->replyText      = '';
    }

    public function submitReply(): void
    {
        $this->validate([
            'replyText' => 'required|string|max:500',
        ], [
            'replyText.required' => 'Tulis balasan terlebih dahulu.',
        ]);

        $store = auth()->user()->store;

        // Make sure the review belongs to one of this seller's products
        $review = Review::find($this->replyTarget);

        if (! $review) {
            $this->dispatch('toast', message: 'Ulasan tidak ditemukan.', type: 'error');
            return;
        }

        $product = Product::find($review->product_id);

        if (! $product || (string) $product->store_id !== (string) $store->_id) {
            $this->dispatch('toast', message: 'Anda tidak berwenang membalas ulasan ini.', type: 'error');
            return;
        }

        $review->seller_reply      = $this->replyText;
        $review->seller_replied_at = now();
        $review->save();

        $this->closeReplyModal();
        $this->dispatch('toast', message: 'Balasan berhasil dikirim.');
    }

    public function render()
    {
        $store = auth()->user()->store;

        // Get all product IDs belonging to this store
        $productIds = Product::where('store_id', (string) $store?->_id)
            ->pluck('_id')
            ->map(fn($id) => (string) $id)
            ->toArray();

        $query = Review::whereIn('product_id', $productIds)
            ->with(['user', 'product'])
            ->orderBy('created_at', 'desc');

        if ($this->filterRating) {
            $query->byRating((int) $this->filterRating);
        }

        $reviews = $query->paginate(15);

        // Summary stats
        $allReviews   = Review::whereIn('product_id', $productIds)->get(['rating']);
        $avgRating    = $allReviews->isNotEmpty() ? round($allReviews->avg('rating'), 1) : 0;
        $totalReviews = $allReviews->count();
        $unreplied    = Review::whereIn('product_id', $productIds)
            ->whereNull('seller_reply')
            ->count();

        return view('livewire.seller.review-insight', [
            'reviews'      => $reviews,
            'avgRating'    => $avgRating,
            'totalReviews' => $totalReviews,
            'unreplied'    => $unreplied,
        ]);
    }
}
