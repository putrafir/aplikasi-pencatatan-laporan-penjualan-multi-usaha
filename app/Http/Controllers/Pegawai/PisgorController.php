<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PisgorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $menus = Menu::where('business_id', 1)->get();
        return view('pegawai.PisGor.index', compact('user', 'menus'));
    }
}
