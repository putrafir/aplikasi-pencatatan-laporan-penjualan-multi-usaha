<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('pegawai.profile', compact('user'));
    }

    public function updetStok()
    {
        $user = Auth::user();
        return view('pegawai.UpdateStok', compact('user'));
    }
}
