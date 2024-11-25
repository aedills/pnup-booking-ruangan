<?php

namespace App\Http\Controllers;

use App\Models\MDataRuangRapat;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
}
