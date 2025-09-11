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

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $businesses = Business::with('transaksis')->get();

        $tanggal = $request->input('tanggal');
        $filterDate = $tanggal ?? now()->toDateString();

        // Ambil transaksi sesuai tanggal filter
        $filteredTransactions = Transaksi::whereDate('created_at', $filterDate)->with('business')->get();

        // Ambil stok yang dimasukkan sesuai tanggal filter
        $stocksAddedToday = StockLog::whereDate('created_at', $filterDate)
            ->where('type', 'masuk')
            ->with('stocks.business')
            ->get()
            ->groupBy('stocks.business_id');

        // Ambil stok yang habis (tidak perlu filter tanggal)
        $remainingStocks = Stock::with('business')->get()->groupBy('business_id');

        // Kelompokkan transaksi berdasarkan bisnis
        $businessData = $businesses->map(function ($business) use ($filteredTransactions) {
            $transactions = $filteredTransactions->where('business_id', $business->id);

            $transactionDetails = [];
            $totalProfit = 0;

            foreach ($transactions as $transaction) {
                $details = json_decode($transaction->details, true);

                foreach ($details as $detail) {
                    $menuName = $detail['nama'] ?? 'Unknown Menu';
                    $size = $detail['ukuran'] ?? '';
                    $quantity = $detail['jumlah'] ?? 0;
                    $price = $detail['harga'] ?? 0;

                    $subtotal = $quantity * $price;
                    $totalProfit += $subtotal;

                    $transactionDetails[] = [
                        'menu_name' => $menuName,
                        'size' => $size,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal,
                    ];
                }
            }

            return [
                'business_name' => $business->name,
                'transactions' => $transactionDetails,
                'total_profit' => $totalProfit,
            ];
        });

        // Hitung total pendapatan hari ini (atau tanggal filter)
        $totalPendapatanHariIni = $filteredTransactions->sum(function ($trx) {
            $details = json_decode($trx->details, true);
            return collect($details)->sum(function ($detail) {
                return ($detail['jumlah'] ?? 0) * ($detail['harga'] ?? 0);
            });
        });

        // Perbaiki: Awal dan akhir minggu/bulan berdasarkan tanggal filter
        $startOfWeek = \Carbon\Carbon::parse($filterDate)->startOfWeek();
        $endOfWeek = \Carbon\Carbon::parse($filterDate)->endOfWeek();
        $startOfMonth = \Carbon\Carbon::parse($filterDate)->startOfMonth();
        $endOfMonth = \Carbon\Carbon::parse($filterDate)->endOfMonth();

        $totalPendapatanMingguIni = Transaksi::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get()
            ->sum(function ($trx) {
                $details = json_decode($trx->details, true);
                return collect($details)->sum(function ($detail) {
                    return ($detail['jumlah'] ?? 0) * ($detail['harga'] ?? 0);
                });
            });

        $totalPendapatanBulanIni = Transaksi::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get()
            ->sum(function ($trx) {
                $details = json_decode($trx->details, true);
                return collect($details)->sum(function ($detail) {
                    return ($detail['jumlah'] ?? 0) * ($detail['harga'] ?? 0);
                });
            });

        return view('admin.dashboard', compact(
            'businessData',
            'stocksAddedToday',
            'remainingStocks',
            'totalPendapatanHariIni',
            'totalPendapatanMingguIni',
            'totalPendapatanBulanIni'
        ));
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
