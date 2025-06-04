<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Transaksi;
use App\Models\Stock;
use App\Models\StockLog;
use App\Models\StokLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {

        $businesses = Business::with('transaksis')->get();

        // Ambil semua transaksi hari ini
        $todayTransactions = Transaksi::whereDate('created_at', now()->toDateString())->with('business')->get();

        // Ambil stok yang dimasukkan hari ini berdasarkan tabel stok_log
        $stocksAddedToday = StockLog::whereDate('created_at', now()->toDateString())
            ->where('type', 'masuk') // Filter stok masuk
            ->with('stocks.business') // Relasi ke bisnis melalui stok
            ->get()
            ->groupBy('stocks.business_id');

        // Ambil stok yang habis hari ini berdasarkan tabel stok_log
        $remainingStocks = Stock::with('business') // Relasi ke bisnis
            ->get()
            ->groupBy('business_id');

        // Kelompokkan transaksi berdasarkan bisnis
        $businessData = $businesses->map(function ($business) use ($todayTransactions) {
            $transactions = $todayTransactions->where('business_id', $business->id);

            $transactionDetails = [];
            $totalProfit = 0;

            foreach ($transactions as $transaction) {
                $details = json_decode($transaction->details, true);

                foreach ($details as $detail) {
                    $menuName = $detail['nama'] ?? 'Unknown Menu';
                    $size = $detail['ukuran'];
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

        return view('admin.dashboard', compact('businessData', 'stocksAddedToday', 'remainingStocks'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }
}
