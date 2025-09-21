<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->query('date', now()->toDateString());

        $business = Business::with([
            'transaksis' => function ($q) use ($tanggal) {
                $q->whereDate('created_at', $tanggal);
            },
            'stocks' => function ($q) use ($tanggal) {
                $q->whereDate('created_at', $tanggal);
            },
        ])->get();

        return view('admin.laporan.index', compact('business', 'tanggal'));
    }

    public function getData(Request $request)
    {
        dd($request->query('date'));
        // Ambil query string ?date=YYYY-MM-DD
        $date = $request->query('date', now()->toDateString());

        $businesses = Business::withCount([
            'stocks' => function ($q) use ($date) {
                $q->whereDate('created_at', $date);
            }
        ])
            ->with([
                'transaksis' => function ($q) use ($date) {
                    $q->whereDate('created_at', $date);
                }
            ])
            ->get();

        $data = $businesses->map(function ($b) {
            return [
                'id' => $b->id,
                'name' => $b->name,
                'pendapatan' => $b->transaksis->sum('total_bayar'),
                'transaksi_count' => $b->transaksis->count(),
                'stocks_count' => $b->stocks_count, // dari withCount
            ];
        });

        return response()->json($data);
    }

    public function getStocks($id)
    {
        $usaha = Business::with('stocks')->findOrFail($id);
        return response()->json($usaha->stocks);
    }

    public function detailLaporan($id, Request $request)
    {
        $tanggal = $request->query('date', now()->toDateString());

        $business = Business::with([
            'transaksis' => function ($q) use ($tanggal) {
                $q->whereDate('created_at', $tanggal);
            },

            'stocks' => function ($q) use ($tanggal) {
                $q->whereDate('created_at', $tanggal);
            },
            'users',
        ])->findOrFail($id);

        return view('admin.laporan.detailLaporan', compact('business', 'tanggal'));
    }

    public function laporanPegawai($id)
    {
        $pegawai = \App\Models\User::findOrFail($id);
        $transaksis = \App\Models\Transaksi::where('user_id', $id)->get();
        $jumlahTransaksi = $transaksis->count();

        return view('admin.laporan.laporanPegawai', compact('pegawai', 'transaksis', 'jumlahTransaksi'));
    }

}
