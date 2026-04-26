<?php

use App\Livewire\Storefront\Home;
use App\Livewire\Storefront\ProductIndex;
use App\Livewire\Storefront\ProductDetail;
use App\Livewire\Storefront\CartPage;
use App\Livewire\Storefront\Checkout;
use App\Livewire\Storefront\OrderHistory;
use App\Livewire\Storefront\OrderDetail;
use App\Livewire\Storefront\WishlistPage;
use App\Livewire\Storefront\RewardsPage;
use App\Livewire\Seller\Dashboard as SellerDashboard;
use App\Livewire\Seller\ProductList as SellerProductList;
use App\Livewire\Seller\ProductForm as SellerProductForm;
use App\Livewire\Seller\OrderList as SellerOrderList;
use App\Livewire\Seller\Promotions as SellerPromotions;
use App\Livewire\Seller\Settings as SellerSettings;
use App\Livewire\Seller\ReviewInsight as SellerReviewInsight;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Storefront Routes (Customer / Public)
|--------------------------------------------------------------------------
*/

Route::get('/', Home::class)->name('home');
Route::get('/produk', ProductIndex::class)->name('products.index');
Route::get('/produk/{slug}', ProductDetail::class)->name('products.show');

// Authenticated customer routes
Route::middleware(['auth'])->group(function () {
    Route::view('profile', 'profile')->name('profile');
    Route::get('/keranjang', CartPage::class)->name('cart');
    Route::get('/checkout', Checkout::class)->name('checkout');
    Route::get('/pesanan', OrderHistory::class)->name('orders.index');
    Route::get('/pesanan/{orderNumber}', OrderDetail::class)->name('orders.show');
    Route::get('/wishlist', WishlistPage::class)->name('wishlist');
    Route::get('/rewards', RewardsPage::class)->name('rewards');
});

/*
|--------------------------------------------------------------------------
| Seller Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::prefix('seller')->middleware(['auth', 'seller'])->group(function () {
    Route::get('/', SellerDashboard::class)->name('seller.dashboard');
    Route::get('/products', SellerProductList::class)->name('seller.products');
    Route::get('/products/create', SellerProductForm::class)->name('seller.products.create');
    Route::get('/products/{id}/edit', SellerProductForm::class)->name('seller.products.edit');
    Route::get('/orders', SellerOrderList::class)->name('seller.orders');
    Route::get('/promotions', SellerPromotions::class)->name('seller.promotions');
    Route::get('/reviews', SellerReviewInsight::class)->name('seller.reviews');
    Route::get('/settings', SellerSettings::class)->name('seller.settings');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Database seeding route (for production deployment)
Route::get('/seed-database', function () {
    if (app()->environment('production')) {
        try {
            \Artisan::call('db:seed');
            return response()->json([
                'success' => true,
                'message' => 'Database berhasil di-seed dengan data sample!',
                'output' => \Artisan::output()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saat seeding database: ' . $e->getMessage()
            ], 500);
        }
    }
    return response()->json(['success' => false, 'message' => 'Route hanya tersedia di production'], 403);
})->name('seed.database');

Route::post('/logout', function (\App\Livewire\Actions\Logout $logout) {
    $logout();
    return redirect('/');
})->name('logout');

require __DIR__.'/auth.php';
