<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pegawai.Miss.index', compact('user'));
    }
}
