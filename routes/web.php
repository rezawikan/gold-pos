<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::get('home', function () {
    return view('home');
});

Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index']);
Route::get('/gold-stock', \App\Livewire\Pages\GoldStock::class)->name('gold-stock');

//Route::view('dashboard', 'dashboard')
//    ->middleware(['auth', 'verified'])
//    ->name('dashboard');

//Route::view('profile', 'profile')
//    ->middleware(['auth'])
//    ->name('profile');
