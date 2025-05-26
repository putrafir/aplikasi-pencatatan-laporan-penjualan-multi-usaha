<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('pegawai.profile', compact('user'));
    }

    public function updetStok(Request $request)
    {
        $user = Auth::user();
        $business_id = $user->id_business;

        $stocks = Stock::where('business_id', $business_id)->get();

        return view('pegawai.UpdateStok', compact('user', 'stocks', 'business_id'));
    }
}
