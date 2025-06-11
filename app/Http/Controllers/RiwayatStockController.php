<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockLog;
use Illuminate\Http\Request;

class RiwayatStockController extends Controller
{
    public function index(Request $request)
    {
        $businessId = $request->input('usaha_id');
        $stockId = $request->input('stock_id');
        $search = $request->input('search');

        $sortBy = $request->input('sort_by', 'created_at');
        $sortDir = $request->input('sort_dir', 'desc');

        $stocks = Stock::with('business')->get();

        $stocksLog = StockLog::with(['stocks.business']);

        if ($businessId) {
            $stocksLog->whereHas('stocks', function ($query) use ($businessId) {
                $query->where('business_id', $businessId);
            });
        }

        if ($stockId) {
            $stocksLog->where('stock_id', $stockId);
        }

        if ($search) {
            $stocksLog->where(function ($query) use ($search) {
                $query->whereHas('stocks', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })
                    ->orWhere('created_at', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $stocksLog = $stocksLog->orderBy($sortBy, $sortDir)->get();

        return view('admin.riwayat-stock.index', compact('stocks', 'stocksLog', 'businessId', 'stockId', 'search'));
    }

    public function show($id)
    {
        $stock = Stock::findOrFail($id);
        return view('riwayat_stock.show', compact('stock'));
    }
}
