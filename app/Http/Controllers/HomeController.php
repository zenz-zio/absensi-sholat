<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $level = Auth::user()->level;
            if ($level == 'administrator') {
                return redirect()->route('admin.dashboard');
            } else if ($level == 'petugas') {
                return redirect()->route('petugas.dashboard');
            } else if ($level == 'peminjam') {
                return redirect()->route('peminjam.dashboard');
            } else {
                return redirect('home');
            }
        } else {
            return redirect('home');
        }
    }
}