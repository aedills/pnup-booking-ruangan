<?php

namespace App\Http\Controllers;

use App\Models\MDataRuangRapat;
use Illuminate\Http\Request;

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
}
