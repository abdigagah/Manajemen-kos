<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::livewire('/admin', 'pages::admin.index')->name('admin');

   Route::livewire('/kamar', 'pages::kamar.index')->name('kamar');
});

require __DIR__.'/settings.php';