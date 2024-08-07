<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::get('home', function () {
    return view('home');
});

Route::middleware(['auth', 'verified'])->group(function () {
    //    Route::view('profile', 'profile')
    //        ->name('profile');
    Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index']);
    Route::get('/dashboard', \App\Livewire\Pages\Dashboard::class)->name('dashboard');
    Route::get('/gold-stock', \App\Livewire\Pages\GoldStock::class)->name('gold-stock');
    Route::get('/orders/create', \App\Livewire\Pages\CreateOrder::class)->name('create-order');
    Route::get('/orders', \App\Livewire\Pages\Order::class)->name('orders');
    Route::get('/gold-stock/update/{id}', \App\Livewire\Pages\UpdateGold::class)->name('update-gold');
    Route::get('/customers', \App\Livewire\Pages\Customers::class)->name('customers');
    Route::get('crawler', [\App\Http\Controllers\CrawlerController::class, 'index']);
});
