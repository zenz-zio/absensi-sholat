<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('dashboard.user.index');
    }

    public function riwayat()
    {
        return view('dashboard.user.riwayat');
    }
}
