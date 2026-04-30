<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Catalog data lives in config/catalog.php and feeds:
|   - /services            (index)
|   - /services/{slug}     (category sub-page)
|   - /shop                (catalog with cart)
|   - /shop/{slug}         (product detail)
|
*/

Route::get('/', fn () => view('home'))->name('home');

Route::get('/services', fn () => view('services'))->name('services');

Route::get('/services/{slug}', function (string $slug) {
    $cat = config("catalog.categories.$slug");
    abort_unless($cat, 404);
    return view('services-category', ['cat' => $cat]);
})->name('services.category');

Route::get('/shop', fn () => view('shop'))->name('shop');

Route::get('/shop/{slug}', function (string $slug) {
    foreach (config('catalog.categories', []) as $cat) {
        foreach ($cat['items'] as $item) {
            if (($item['slug'] ?? null) === $slug) {
                return view('shop-detail', ['item' => $item, 'cat' => $cat]);
            }
        }
    }
    abort(404);
})->name('shop.detail');

Route::get('/pricing', fn () => view('pricing'))->name('pricing');
Route::get('/privacy', fn () => view('privacy'))->name('privacy');
Route::get('/refund',  fn () => view('refund'))->name('refund');
Route::get('/terms',   fn () => view('terms'))->name('terms');
