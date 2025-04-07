<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PisgorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $menus = Menu::where('business_id', 1)->get();
        return view('pegawai.PisGor.index', compact('user', 'menus'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'ukuran' => 'nullable|string',
        ]);

        $menu = Menu::with('kategori.sizePrices.size')->findOrFail($request->menu_id);
        $businessId = Auth::user()->id_business;

        $isSmoothies = $menu->kategori_id == 1 && $menu->business_id == 2;

        // Hitung harga
        if ($isSmoothies) {
            $sizePrice = $menu->kategori->sizePrices()
                ->whereHas('size', function ($q) use ($request) {
                    $q->where('nama', $request->ukuran);
                })->first();

            if (!$sizePrice) {
                return redirect()->back()->with('error', 'Ukuran tidak valid atau tidak ditemukan.');
            }

            $harga = $sizePrice->harga;
        } else {
            $harga = $menu->harga;
        }

        // Cari apakah sudah ada item ini dalam keranjang
        $keranjang = Keranjang::where('menu_id', $request->menu_id)
            ->where('business_id', $businessId)
            ->when($isSmoothies, function ($query) use ($request) {
                return $query->where('ukuran', $request->ukuran);
            })
            ->first();

        if ($keranjang) {
            $keranjang->jumlah += 1;
            $keranjang->harga_satuan = $harga; // simpan harga terbaru jika berubah
            $keranjang->total_harga = $keranjang->jumlah * $harga;
            $keranjang->save();
        } else {
            Keranjang::create([
                'menu_id' => $request->menu_id,
                'jumlah' => 1,
                'harga_satuan' => $harga,
                'total_harga' => $harga,
                'business_id' => $businessId,
                'ukuran' => $isSmoothies ? $request->ukuran : null,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function viewCart()
    {
        $keranjangs = Keranjang::with('menu')->where('business_id', 1)->get();
        $totalBayar = $keranjangs->sum('total_harga');
        return view('pegawai.Pisgor.keranjang', compact('keranjangs', 'totalBayar'));
    }
}
