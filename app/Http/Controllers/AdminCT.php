<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCT extends Controller
{
    public function index(Request $request)
    {
        return view('admin/dashboard', [
            'title' => 'Sirara | Dashboard'
        ]);
    }
}