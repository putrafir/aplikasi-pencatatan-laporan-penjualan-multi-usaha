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
        $filterPendapatan = $request->get('filter_pendapatan', 'minggu');
        $filterStok = $request->get('filter_stok', 'minggu');

        if ($filterPendapatan == 'bulan') {
            // =================== PENJUALAN (TRANSAKSI) ===================
            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();

            $weeks = [];
            $categoriesPendapatan = [];
            $current = $startOfMonth->copy();
            while ($current <= $endOfMonth) {
                $startOfWeek = $current->copy();
                $endOfWeek = $current->copy()->endOfWeek();
                if ($endOfWeek > $endOfMonth) $endOfWeek = $endOfMonth->copy();

                $weeks[] = [
                    'start' => $startOfWeek->copy(),
                    'end' => $endOfWeek->copy(),
                    'label' => $startOfWeek->format('j') . ' - ' . $endOfWeek->format('j M'),
                    'yearweek' => $startOfWeek->format('oW'),
                ];

                $categoriesPendapatan[] = $startOfWeek->format('j') . ' - ' . $endOfWeek->format('j M');
                $current = $endOfWeek->addDay();
            }

            $transactions = DB::table('transaksis')
                ->join('business', 'transaksis.business_id', '=', 'business.id')
                ->selectRaw('YEARWEEK(transaksis.created_at, 3) as yearweek, business.name as business, COUNT(transaksis.id) as total_transaksi, SUM(transaksis.total_bayar) as total_pendapatan')
                ->whereBetween('transaksis.created_at', [$startOfMonth, $endOfMonth])
                ->groupByRaw('YEARWEEK(transaksis.created_at, 3), business.name')
                ->orderBy('yearweek', 'asc')
                ->get();

            $seriesPendapatan = [];
            foreach ($transactions->groupBy('business') as $usaha => $data) {
                $seriesPendapatan[] = [
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
            // =================== PENJUALAN (TRANSAKSI) ===================
            $startOfWeek = now()->startOfWeek();
            $endOfWeek = now()->endOfWeek();

            $transactions = DB::table('transaksis')
                ->join('business', 'transaksis.business_id', '=', 'business.id')
                ->selectRaw('DATE(transaksis.created_at) as tanggal, business.name as business, COUNT(transaksis.id) as total_transaksi, SUM(transaksis.total_bayar) as total_pendapatan')
                ->whereBetween('transaksis.created_at', [$startOfWeek, $endOfWeek])
                ->groupByRaw('DATE(transaksis.created_at), business.name')
                ->orderBy('tanggal', 'asc')
                ->get();

            $categoriesPendapatan = collect();
            for ($date = $startOfWeek->copy(); $date <= $endOfWeek; $date->addDay()) {
                $categoriesPendapatan->push($date->format('Y-m-d'));
            }

            $seriesPendapatan = [];
            foreach ($transactions->groupBy('business') as $usaha => $data) {
                $seriesPendapatan[] = [
                    'name' => $usaha,
                    'data' => $categoriesPendapatan->map(function ($tanggal) use ($data) {
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


        if ($filterStok == 'bulan') {
            // =================== STOK KELUAR ===================

            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();

            $weeks = [];
            $categoriesStok = [];
            $current = $startOfMonth->copy();
            while ($current <= $endOfMonth) {
                $startOfWeek = $current->copy();
                $endOfWeek = $current->copy()->endOfWeek();
                if ($endOfWeek > $endOfMonth) $endOfWeek = $endOfMonth->copy();

                $weeks[] = [
                    'start' => $startOfWeek->copy(),
                    'end' => $endOfWeek->copy(),
                    'label' => $startOfWeek->format('j') . ' - ' . $endOfWeek->format('j M'),
                    'yearweek' => $startOfWeek->format('oW'),
                ];

                $categoriesStok[] = $startOfWeek->format('j') . ' - ' . $endOfWeek->format('j M');
                $current = $endOfWeek->addDay();
            }
            $stokLogs = DB::table('stock_log')
                ->join('stock', 'stock_log.stock_id', '=', 'stock.id')
                ->join('business', 'stock.business_id', '=', 'business.id')
                ->selectRaw('YEARWEEK(stock_log.created_at, 3) as yearweek, business.name as business, SUM(stock_log.stok_keluar) as total_stok_keluar')
                ->whereBetween('stock_log.created_at', [$startOfMonth, $endOfMonth])
                ->groupByRaw('YEARWEEK(stock_log.created_at, 3), business.name')
                ->orderBy('yearweek', 'asc')
                ->get();

            $stokSeries = [];
            foreach ($stokLogs->groupBy('business') as $usaha => $data) {
                $stokSeries[] = [
                    'name' => $usaha,
                    'data' => collect($weeks)->map(function ($week) use ($data) {
                        $row = $data->firstWhere('yearweek', $week['yearweek']);
                        return [
                            'stok_keluar' => $row ? $row->total_stok_keluar : 0,
                        ];
                    })->values()->toArray()
                ];
            }

            $totalStokKeluar = $stokLogs->sum('total_stok_keluar');
        } else {
            // =================== STOK KELUAR ===================

            $startOfWeek = now()->startOfWeek();
            $endOfWeek = now()->endOfWeek();

            $stokLogs = DB::table('stock_log')
                ->join('stock', 'stock_log.stock_id', '=', 'stock.id')
                ->join('business', 'stock.business_id', '=', 'business.id')
                ->selectRaw('DATE(stock_log.created_at) as tanggal, business.name as business, SUM(stock_log.stok_keluar) as total_keluar')
                ->groupByRaw('DATE(stock_log.created_at), business.name')
                ->orderBy('tanggal', 'asc')
                ->get();
            $categoriesStok = collect();
            for ($date = $startOfWeek->copy(); $date <= $endOfWeek; $date->addDay()) {
                $categoriesStok->push($date->format('Y-m-d'));
            }
            $stokSeries = [];
            foreach ($stokLogs->groupBy('business') as $usaha => $data) {
                $stokSeries[] = [
                    'name' => $usaha,
                    'data' => $categoriesStok->map(function ($tanggal) use ($data) {
                        $row = $data->firstWhere('tanggal', $tanggal);
                        return [
                            'stok_keluar' => $row ? $row->total_keluar : 0,
                        ];
                    })
                ];
            }

            $totalStokKeluar = $stokLogs->sum('total_keluar');
        }

        return view('admin.dashboard', [
            'categoriesPendapatan' => $categoriesPendapatan,
            'categoriesStok' => $categoriesStok,
            'seriesPendapatan' => $seriesPendapatan,          // pendapatan + transaksi
            'stokSeries' => $stokSeries,  // stok keluar
            'filterPendapatan' => $filterPendapatan,
            'filterStok' => $filterStok,
            'totalPendapatan' => $totalPendapatan,
            'totalStokKeluar' => $totalStokKeluar,

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
