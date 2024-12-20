<?php

use App\Http\Controllers\AdminBookingCT;
use App\Http\Controllers\AdminCT;
use App\Http\Controllers\DataGedung;
use App\Http\Controllers\RuangRapatCT;
use App\Http\Controllers\UserCT;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('user.index');
});

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AdminCT::class, 'login'])->name('login');
    Route::post('/doLogin', [AdminCT::class, 'doLogin'])->name('doLogin');
    Route::post('/changePass', [AdminCT::class, 'changePass'])->name('changePass');

    Route::get('/logout', [AdminCT::class, 'logout'])->name('logout');
});

Route::prefix('admin')->name('admin.')->middleware('is.admin')->group(function () {
    Route::get('', [AdminCT::class, 'index'])->name('dashboard');
    Route::post('changeNumber', [AdminCT::class, 'changeNumber'])->name('changeNumber');

    Route::prefix('data-ruangan')->name('data-ruangan.')->group(function () {
        Route::prefix('rapat')->name('rapat.')->group(function () {
            Route::get('/', [RuangRapatCT::class, 'index'])->name('index');
            Route::get('/create', [RuangRapatCT::class, 'create'])->name('create');
            Route::post('/store', [RuangRapatCT::class, 'store'])->name('store');
            Route::get('/edit/{uuid}', [RuangRapatCT::class, 'edit'])->name('edit');
            Route::get('/detail/{uuid}', [RuangRapatCT::class, 'detail'])->name('detail');
            Route::post('/update', [RuangRapatCT::class, 'update'])->name('update');
            Route::post('/delete', [RuangRapatCT::class, 'delete'])->name('delete');

            Route::post('/deleteFoto', [RuangRapatCT::class, 'deleteFoto'])->name('deleteFoto');
        });
    });

    Route::prefix('data-gedung')->name('gedung.')->group(function () {
        Route::get('/', [DataGedung::class, 'index'])->name('index');
        Route::get('/create', [DataGedung::class, 'create'])->name('create');
        Route::post('/store', [DataGedung::class, 'store'])->name('store');
        Route::post('/update', [DataGedung::class, 'update'])->name('update');
        Route::post('/delete', [DataGedung::class, 'delete'])->name('delete');
    });

    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/list', [AdminBookingCT::class, 'list'])->name('list');
        Route::get('/detail/{uuid}', [AdminBookingCT::class, 'detail'])->name('detail');
        Route::post('/accept', [AdminBookingCT::class, 'accept'])->name('accept');
        Route::post('/decline', [AdminBookingCT::class, 'decline'])->name('decline');
        Route::post('/cancel', [AdminBookingCT::class, 'cancel'])->name('cancel');

        Route::get('/riwayat', [AdminBookingCT::class, 'riwayat'])->name('riwayat');
    });
});

Route::prefix('/user')->name('user.')->group(function () {
    Route::get('/list', [UserCT::class, 'list'])->name('list');
    Route::get('/booking/{uuid}', [UserCT::class, 'booking'])->name('booking');
    Route::post('/booking/{uuid}', [UserCT::class, '_booking'])->name('booking');
    Route::get('/riwayat', [UserCT::class, 'riwayat'])->name('riwayat');

    Route::get('/search', [UserCT::class, 'search'])->name('search');
    Route::post('/search', [UserCT::class, 'doSearch'])->name('doSearch');

    Route::post('/checkAvailable', [UserCT::class, 'checkAvailability'])->name('checkAvailability');

    Route::get('/{date?}', [UserCT::class, 'index'])->name('index');
});
