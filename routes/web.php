<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Admin
   Route::resource('admin', AdminController::class);

    // Kamar
    Route::view('/kamar', 'kamar.index')->name('kamar');

    // Kamar Kosong
    Route::view('/kamar-kosong', 'kamar.kosong')->name('kamar.kosong');

    // Kamar Terisi
    Route::view('/kamar-terisi', 'kamar.terisi')->name('kamar.terisi');

});

require __DIR__.'/settings.php';