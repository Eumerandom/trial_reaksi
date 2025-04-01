<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/product', App\Livewire\Product\Index::class)->name('product.index');
