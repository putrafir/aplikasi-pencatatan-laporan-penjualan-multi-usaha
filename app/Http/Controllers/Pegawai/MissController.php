<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissController extends Controller
{
    public function index(request $request)
    {
        $user = Auth::user();
        $query = Menu::where('business_id', 2);

        // filter berdasarkan superkategori
        if ($request->filled('superKategori')) {
            $query->whereHas('kategori.superKategori', function ($q) use ($request) {
                $q->where('nama', $request->kategori);
            });
        }

        // Filter berdasarkan nama kategori
        if ($request->filled('kategori_nama')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama', $request->kategori_nama);
            });
        }

        // Filter pencarian nama produk
        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }

        $menus = $query->get();

        $jumlah_item = Keranjang::where('business_id', 2)->sum('jumlah');

        $allKategori = Menu::where('business_id', 2)
            ->with('kategori')
            ->get()
            ->pluck('kategori.nama')
            ->unique()
            ->sort()
            ->values();

        $kategoriList = Menu::where('business_id', 2)
            ->with('kategori')
            ->get()
            ->pluck('kategori')
            ->unique('id')
            ->values();


        return view('pegawai.Miss.index', compact('user', 'menus', 'allKategori', 'jumlah_item', 'kategoriList'));
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

        $keranjang = Keranjang::where('menu_id', $request->menu_id)
            ->where('business_id', $businessId)
            ->when($isSmoothies, function ($query) use ($request) {
                return $query->where('ukuran', $request->ukuran);
            })
            ->first();

        if ($keranjang) {
            $keranjang->jumlah += 1;
            $keranjang->harga_satuan = $harga;
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
        $keranjangs = Keranjang::with('menu')->where('business_id', 2)->get();
        $totalBayar = $keranjangs->sum('total_harga');
        return view('pegawai.Miss.keranjang', compact('keranjangs', 'totalBayar'));
    }

    public function removeFromCart($id)
    {
        $keranjang = Keranjang::findOrFail($id);
        $keranjang->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'uang_dibayarkan' => 'required|numeric|min:0',
        ]);

        $keranjangs = Keranjang::all();

        if ($keranjangs->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong, tidak ada yang bisa dibayar.');
        }

        $totalBayar = $keranjangs->sum('total_harga');

        if ($request->uang_dibayarkan < $totalBayar) {
            return redirect()->back()->with('error', 'Uang yang dibayarkan tidak cukup.');
        }

        $kembalian = $request->uang_dibayarkan - $totalBayar;

        $businessId = Auth::user()->id_business;

        $details = $keranjangs->map(function ($keranjang) {
            return [
                'menu_id' => $keranjang->menu_id,
                'nama' => $keranjang->menu->nama,
                'jumlah' => $keranjang->jumlah,
                'harga' => $keranjang->harga_satuan,
                'subtotal' => $keranjang->total_harga,
                'ukuran' => $keranjang->ukuran,
                'extra_topping' => $keranjang->extra_topping,
            ];
        });

        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'business_id' => $businessId,
            'total_bayar' => $totalBayar,
            'uang_dibayarkan' => $request->uang_dibayarkan,
            'kembalian' => $kembalian,
            'details' => $details->toJson(),
        ]);

        Keranjang::where('business_id', Auth::user()->id_business)->delete();

        return redirect()->back()->with('success', "Pembayaran berhasil. Uang yang di bayarkan: Rp " . number_format($request->uang_dibayarkan, 0, ',', '.') . ". Kembalian: Rp " . number_format($kembalian, 0, ',', '.'));
    }
}
