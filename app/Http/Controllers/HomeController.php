<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        $role = Auth::user()->role;

        if ($role === 'guru') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'siswa') {
            return redirect()->route('user.dashboard');
        }

        return redirect()->route('login');
    }
}
