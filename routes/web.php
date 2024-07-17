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
    Route::get('/gold-stock', \App\Livewire\Pages\GoldStock::class)->name('gold-stock');
    Route::get('crawler', [\App\Http\Controllers\CrawlerController::class, 'index']);
});
