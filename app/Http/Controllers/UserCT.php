<?php

namespace App\Http\Controllers;

use App\Models\MDataRuangRapat;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserCT extends Controller
{
    public function index(Request $request)
    {
        $allRoom = MDataRuangRapat::with('gedung')->get();

        // $room = [];
        // foreach($allRoom as $ar){

        // }
        return view('user/dashboard', [
            'title' => 'SIRARA | Dashboard',

            'listRuang' => $allRoom
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
