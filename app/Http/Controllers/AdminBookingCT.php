<?php

namespace App\Http\Controllers;

use App\Models\MDataBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminBookingCT extends Controller
{
    public function list(Request $request)
    {
        Carbon::setLocale('id');
        $date = Carbon::now()->format('Y-m-d');

        $pending = MDataBooking::where('status', 'none')->where('tanggal', '>=', $date)->with('ruang')->orderBy('tanggal', 'asc')->get();
        $acc = MDataBooking::where('status', 'accept')->where('tanggal', '>=', $date)->with('ruang')->orderBy('tanggal', 'asc')->get();
        // dd($pending);

        return view('admin.booking.daftar', [
            'title' => 'Booking List | SIRARA',
            'page_title' => 'Daftar Booking',

            'pending' => $pending,
            'accept' => $acc,
        ]);
    }

    public function detail(Request $request)
    {
        return view('admin.booking.detail', [
            'title' => 'Booking List | SIRARA',
            'page_title' => 'Riwayat Booking',
        ]);
    }

    public function accept(Request $request)
    {
        try {
            if ($request->uuid) {
                return response()->json([
                    'success' => true,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation Error',
                    'errors' => 'Terdapat kesalahan pada parameter UUID'
                ], 422);
            }
        } catch (\Exception $err) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $err->getMessage()
            ], 500);
        }
    }
}
