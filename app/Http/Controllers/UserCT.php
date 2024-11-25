<?php

namespace App\Http\Controllers;

use App\Models\MDataRuangRapat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserCT extends Controller
{
    public function index(Request $request)
    {
        $allRoom = MDataRuangRapat::with('gedung')->get();

        Carbon::setLocale('id');

        return view('user/dashboard', [
            'title' => 'SIRARA | Dashboard',

            'listRuang' => $allRoom,
            'day' => Carbon::now()->translatedFormat('l')
        ]);
    }

    public function booking(Request $request)
    {
        $room = MDataRuangRapat::where('uuid', $request->uuid)->firstOrFail();
        return view('user.booking', [
            'title' => 'SIRARA | Booking',
            'data' => $room
        ]);
    }
}
