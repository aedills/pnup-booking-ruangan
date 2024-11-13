<?php

use App\Http\Controllers\AdminCT;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('', [AdminCT::class, 'index'])->name('dashboard');
});
