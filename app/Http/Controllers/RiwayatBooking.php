<?php

namespace App\Http\Controllers;

use App\Models\MDataBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class RiwayatBooking extends Controller{
    public function index(Request $request)
    {
        Carbon::setLocale('id');
        $date = Carbon::now()->format('Y-m-d');

        $riwayat = MDataBooking::where('status', 'accept')->where('tanggal', '<=', $date)->with('ruang')->orderBy('tanggal', 'desc')->get();
        return view('admin.booking.riwayat', [
            'title' => 'Riwayat Booking | SIRARA',
            'page_title' => 'Riwayat Booking',
            'riwayat' => $riwayat
        ]);
    }

    public function detail(Request $request){
        return view('admin.booking.detail',[
            'title' => 'Booking List | SIRARA',
            'page_title' => 'Riwayat Booking',
        ]);
    }
}