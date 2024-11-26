<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class RiwayatBooking extends Controller{
    public function index(Request $request)
    {
        return view('admin.booking.riwayat', [
            'title' => 'Booking List | SIRARA',
            'page_title' => 'Riwayat Booking',
        ]);
    }
}