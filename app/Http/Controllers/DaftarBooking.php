<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class DaftarBooking extends Controller{
    public function index(Request $request)
    {
        return view('admin.booking.daftar', [
            'title' => 'Booking List | SIRARA',
            'page_title' => 'Daftar Booking',
        ]);
    }
}