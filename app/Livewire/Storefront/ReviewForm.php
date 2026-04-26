<?php

namespace App\Livewire\Storefront;

use App\Models\Order;
use App\Models\Review;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

/**
 * ReviewForm
 *
 * Embedded in the order-detail page.
 * Shows a review form for each completed order item that has not yet been reviewed.
 * The customer can rate 1-5 stars, write a comment, and optionally upload a photo.
 */
class ReviewForm extends Component
{
    use WithFileUploads;

    public string  $orderId;
    public string  $productId;
    public string  $productName;
    public string  $orderItemImage = '';

    // Form state
    public int     $rating  = 0;       // 0 = not selected
    public string  $comment = '';
    public         $reviewImage = null; // Livewire TemporaryUploadedFile

    public bool    $submitted  = false;
    public bool    $alreadyDone = false;

    public function mount(string $orderId, string $productId, string $productName, string $orderItemImage = '')
    {
        $this->orderId       = $orderId;
        $this->productId     = $productId;
        $this->productName   = $productName;
        $this->orderItemImage = $orderItemImage;

        // Check if already reviewed
        if (auth()->check()) {
            $this->alreadyDone = Review::hasReviewed(
                (string) auth()->user()->_id,
                $productId,
                $orderId
            );
        }
    }

    public function setRating(int $value): void
    {
        $this->rating = $value;
    }

    public function submitReview(): void
    {
        if (! auth()->check()) {
            $this->dispatch('toast', message: 'Silakan login terlebih dahulu.', type: 'error');
            return;
        }

        if ($this->alreadyDone) {
            $this->dispatch('toast', message: 'Anda sudah memberikan ulasan untuk produk ini.', type: 'error');
            return;
        }

        // Validate the order truly belongs to this user and is completed
        $order = Order::where('_id', $this->orderId)
            ->where('user_id', (string) auth()->user()->_id)
            ->where('status', 'completed')
            ->first();

        if (! $order) {
            $this->dispatch('toast', message: 'Pesanan tidak valid atau belum selesai.', type: 'error');
            return;
        }

        $this->validate([
            'rating'      => 'required|integer|min:1|max:5',
            'comment'     => 'required|string|min:10|max:500',
            'reviewImage' => 'nullable|image|max:2048',
        ], [
            'rating.required'  => 'Pilih rating bintang terlebih dahulu.',
            'rating.min'       => 'Rating minimal 1 bintang.',
            'comment.required' => 'Tulis ulasan Anda.',
            'comment.min'      => 'Ulasan minimal 10 karakter.',
        ]);

        $imagePath = null;
        if ($this->reviewImage) {
            $imagePath = $this->reviewImage->store('review-images', 'public');
        }

        Review::create([
            'user_id'           => (string) auth()->user()->_id,
            'product_id'        => $this->productId,
            'order_id'          => $this->orderId,
            'rating'            => $this->rating,
            'comment'           => $this->comment,
            'images'            => $imagePath ? [$imagePath] : [],
            'seller_reply'      => null,
            'seller_replied_at' => null,
            'is_verified_buyer' => true,
            'is_approved'       => true, // auto-approve; add moderation here if needed
            'helpful_count'     => 0,
        ]);

        $this->submitted   = true;
        $this->alreadyDone = true;
        $this->dispatch('toast', message: 'Ulasan Anda berhasil dikirim. Terima kasih!');
    }

    public function render()
    {
        return view('livewire.storefront.review-form');
    }
}
