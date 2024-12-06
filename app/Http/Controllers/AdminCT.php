<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCT extends Controller
{
    public function index(Request $request)
    {
        return view('admin/dashboard', [
            'title' => 'Dashboard | SIRARA'
        ]);
    }

    public function login(Request $request)
    {
        return view('admin/login/index', [
            'title' => 'Sirara | Login'
        ]);
    }
}
