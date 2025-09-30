<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Transaksi;
use App\Models\Stock;
use App\Models\StockLog;
use App\Models\StokLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $filter = $request->get('filter', 'minggu');

        if ($filter == 'bulan') {
            // Penjualan per minggu di bulan ini (minggu penuh)
            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();

            // Buat array minggu penuh dalam bulan
            $weeks = [];
            $categories = [];
            $current = $startOfMonth->copy();
            while ($current <= $endOfMonth) {
                $startOfWeek = $current->copy();
                $endOfWeek = $current->copy()->endOfWeek();
                if ($endOfWeek > $endOfMonth) $endOfWeek = $endOfMonth->copy();

                $weeks[] = [
                    'start' => $startOfWeek->copy(),
                    'end' => $endOfWeek->copy(),

                    'label' => $startOfWeek->format('j') . ' - ' . $endOfWeek->format('j M'),
                    'yearweek' => $startOfWeek->format('oW'), // ISO week
                ];

                $categories[] = $startOfWeek->format('j') . ' - ' . $endOfWeek->format('j M');
                $current = $endOfWeek->addDay();
            }

            // Ambil transaksi per minggu
            $transactions = DB::table('transaksis')
                ->join('business', 'transaksis.business_id', '=', 'business.id')
                ->selectRaw('YEARWEEK(transaksis.created_at, 3) as yearweek, business.name as business, COUNT(transaksis.id) as total_transaksi, SUM(transaksis.total_bayar) as total_pendapatan')
                ->whereBetween('transaksis.created_at', [$startOfMonth, $endOfMonth])
                ->groupByRaw('YEARWEEK(transaksis.created_at, 3), business.name')
                ->orderBy('yearweek', 'asc')
                ->get();

            // Mapping data ke minggu penuh
            $series = [];
            foreach ($transactions->groupBy('business') as $usaha => $data) {
                $series[] = [
                    'name' => $usaha,
                    'data' => collect($weeks)->map(function ($week) use ($data) {
                        $row = $data->firstWhere('yearweek', $week['yearweek']);
                        return [
                            'pendapatan' => $row ? $row->total_pendapatan : 0,
                            'transaksi'  => $row ? $row->total_transaksi : 0,
                        ];
                    })->values()->toArray()
                ];
            }
            $totalPendapatan = $transactions->sum('total_pendapatan');
        } else {
            // Penjualan per hari di minggu ini
            $startOfWeek = now()->startOfWeek();
            $endOfWeek = now()->endOfWeek();

            $transactions = DB::table('transaksis')
                ->join('business', 'transaksis.business_id', '=', 'business.id')
                ->selectRaw('DATE(transaksis.created_at) as tanggal, business.name as business, COUNT(transaksis.id) as total_transaksi, SUM(transaksis.total_bayar) as total_pendapatan')
                ->whereBetween('transaksis.created_at', [$startOfWeek, $endOfWeek])
                ->groupByRaw('DATE(transaksis.created_at), business.name')
                ->orderBy('tanggal', 'asc')
                ->get();

            $categories = collect();
            for ($date = $startOfWeek->copy(); $date <= $endOfWeek; $date->addDay()) {
                $categories->push($date->format('Y-m-d'));
            }

            $series = [];
            foreach ($transactions->groupBy('business') as $usaha => $data) {
                $series[] = [
                    'name' => $usaha,
                    'data' => $categories->map(function ($tanggal) use ($data) {
                        $row = $data->firstWhere('tanggal', $tanggal);
                        return [
                            'pendapatan' => $row ? $row->total_pendapatan : 0,
                            'transaksi'  => $row ? $row->total_transaksi : 0,
                        ];
                    })->values()->toArray()
                ];
            }
            $totalPendapatan = $transactions->sum('total_pendapatan');
        }

        return view('admin.dashboard', [
            'categories' => $categories,
            'series' => $series,
            'filter' => $filter,
            'totalPendapatan' => $totalPendapatan,
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function filterTanggal(Request $request)
    {



        return view('admin.Miss.index', compact('missTransaksis', 'pisgorTransaksis'));
    }
}
