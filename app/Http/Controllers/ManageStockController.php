<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Stock;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageStockController extends Controller
{


    public function pegawaiView(Request $request)
    {
        $user = Auth::user();
        $business = Business::find($user->id_business);

        $stocks = Stock::where('business_id', $business->id)->get();

        return view('pegawai.UpdateStok', compact('user', 'stocks', 'business'));
    }



    public function index(Request $request)
    {
        $business_id = $request->get('business_id', 2);
        $stocks = Stock::when($business_id, function ($query, $business_id) {
            return $query->where('business_id', $business_id);
        })->get();

        $businesses = Business::all();

        $datanama = "data master";

        return view('admin.manage-stock.index', compact('stocks', 'businesses', 'datanama', 'business_id'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_stok' => 'nullable|integer',
            'harga' => 'nullable|integer',
            'business_id' => 'required|exists:business,id',
            'satuan' => 'required|string|max:50',
        ]);


        $validated['jumlah_stok'] = $validated['jumlah_stok'] ?? 0;

        Stock::create($validated);

        return redirect()->back()->with('success', 'Data stok berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'satuan' => 'required|string',
        ]);

        $stock = Stock::findOrFail($id);

        $stock->update([
            'nama' => $request->nama,
            'satuan' => $request->satuan,
        ]);

        return redirect()->back()->with('success', 'Data stok berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();
        return redirect()->back()->with('success', 'Data stok berhasil dihapus');
    }

    public function addJumlahStok(Request $request)
    {
        $business_id = $request->query('business_id');

        if (!$business_id) {
            return redirect()->back()->with('error', 'Business ID tidak ditemukan.');
        }

        $stocks = Stock::where('business_id', $business_id)->get();

        return view('admin.manage-stock.add-jumlah-stok', compact('stocks', 'business_id'));
    }

    public function increaseStock(Request $request)
    {
        $business_id = $request->get('business_id');

        $validated = $request->validate([
            'jumlah_stok' => 'required|array',
            'jumlah_stok.*' => 'nullable|integer|min:0',
        ]);

        foreach ($validated['jumlah_stok'] as $itemId => $jumlah) {
            if ($jumlah > 0) {
                $stock = Stock::findOrFail($itemId);
                $stock->jumlah_stok += $jumlah;
                $stock->save();

                StockLog::create([
                    'stock_id' => $stock->id,
                    'type' => 'masuk',
                    'quantity' => $jumlah,
                    'deskripsi' => 'Stok bertambah',
                ]);
            }
        }

        return redirect()->route('admin.manage-stock', compact('business_id'))->with('success', 'Stok berhasil diperbarui.');
    }
    public function reduceStock(Request $request)
    {
        $validated = $request->validate([
            'jumlah_stok' => 'required|array',
            'jumlah_stok.*' => 'nullable|integer|min:0',
        ]);

        foreach ($validated['jumlah_stok'] as $stockId => $remainingStock) {
            if (is_null($remainingStock)) {
                continue;
            }

            $stock = Stock::findOrFail($stockId);

            $quantityOut = $stock->jumlah_stok - $remainingStock;

            if ($quantityOut < 0) {
                continue;
            }

            $stock->jumlah_stok = $remainingStock;
            $stock->save();

            StockLog::create([
                'stock_id' => $stock->id,
                'type' => 'keluar',
                'quantity' => $quantityOut,
                'deskripsi' => 'Stok keluar',
            ]);
        }
        return redirect()->back()->with('success', 'Sisa stok berhasil diperbarui.');
    }
}
