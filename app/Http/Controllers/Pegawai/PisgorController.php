<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PisgorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pegawai.PisGor.index', compact('user'));
    }
}
