<?php

use App\Http\Controllers\AdminCT;
use App\Http\Controllers\RuangRapatCT;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('', [AdminCT::class, 'index'])->name('dashboard');

    Route::prefix('data-ruangan')->name('data-ruangan.')->group(function () {
        Route::prefix('rapat')->name('rapat.')->group(function () {
            Route::get('/', [RuangRapatCT::class, 'index'])->name('index');
            Route::get('/create', [RuangRapatCT::class, 'create'])->name('create');
            Route::post('/store', [RuangRapatCT::class, 'store'])->name('store');
            Route::get('/edit/{uuid}', [RuangRapatCT::class, 'edit'])->name('edit');
            Route::get('/detail/{uuid}', [RuangRapatCT::class, 'detail'])->name('detail');
            Route::post('/update', [RuangRapatCT::class, 'update'])->name('update');
            Route::post('/delete', [RuangRapatCT::class, 'delete'])->name('delete');
        });
    });
});
