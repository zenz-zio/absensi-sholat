<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role == 'guru') {
                return redirect()->route('admin.dashboard');
            } elseif ($role == 'siswa') {
                return redirect()->route('user.dashboard');
            } else {
                return redirect('login');
            }
        } else {
            return redirect('home');
        }
    }
}
