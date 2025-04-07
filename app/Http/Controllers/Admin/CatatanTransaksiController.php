<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class CatatanTransaksiController extends Controller
{
    public function missView()
    {
        $transaksis = Transaksi::with('user')->where('business_id', 2)->get();
        return view('admin.Miss.index', compact('transaksis'));
    }
    public function pisgorView()
    {
        $transaksis = Transaksi::with('user')->where('business_id', 1)->get();
        return view('admin.Pisgor.index', compact('transaksis'));
    }
}
