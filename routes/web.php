<?php

use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//    return view('welcome');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    // yang ini nggak dipake karena tanpa role
    // Route::get('/post', App\Livewire\Post\Index::class)->name('posts.index');

    Route::get('/post', App\Livewire\Post\Index::class)->name('posts.index')->middleware('role:Siswa');
});

Route::get('/', App\Livewire\Dashboard::class)->name('dashboard');

Route::get('/product', App\Livewire\Product\Index::class)->name('product.index');
Route::get('/product/{slug}', App\Livewire\Product\Show::class)->name('product.show');
Route::get('/berita', \App\Livewire\Post\Index::class)->name('berita.index');
Route::get('/berita/{slug}', \App\Livewire\Post\Show::class)->name('berita.show');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Test Error Pages (hapus di production)
Route::get('/test-500', function () {
    abort(500);
});

Route::get('/test-403', function () {
    abort(403);
});

Route::get('/test-419', function () {
    abort(419);
});

Route::get('/test-404', function () {
    abort(404);
});
