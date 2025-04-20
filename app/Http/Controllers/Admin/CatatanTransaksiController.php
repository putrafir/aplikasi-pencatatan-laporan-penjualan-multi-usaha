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

    public function getTransaksiDetail($id)
    {
        $transaksi = Transaksi::with('user')->findOrFail($id);

        return response()->json([
            'created_at' => $transaksi->created_at->format('d M Y H:i'),
            'user' => [
                'name' => $transaksi->user->name,
            ],
            'total_bayar' => number_format($transaksi->total_bayar, 0, ',', '.'),
            'uang_dibayarkan' => number_format($transaksi->uang_dibayarkan, 0, ',', '.'),
            'kembalian' => number_format($transaksi->kembalian, 0, ',', '.'),
            'details' => json_decode($transaksi->details),
        ]);
    }
}
