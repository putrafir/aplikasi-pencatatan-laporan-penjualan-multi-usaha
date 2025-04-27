<?php

namespace App\Http\Controllers\Pegawai;

use App\Models\Menu;
use App\Models\Size;
use App\Models\Keranjang;
use App\Models\SizePrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PisgorController extends Controller
{
    public function index(request $request)
    {
        $user = Auth::user();
        $query = Menu::where('business_id', 1);

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

        $jumlah_item = Keranjang::where('business_id', 1)->sum('jumlah');

        $allKategori = Menu::where('business_id', 1)
            ->with('kategori')
            ->get()
            ->pluck('kategori.nama')
            ->unique()
            ->sort()
            ->values();

        $kategoriList = Menu::where('business_id', 1)
            ->with('kategori')
            ->get()
            ->pluck('kategori')
            ->unique('id')
            ->values();

        return view('pegawai.PisGor.index', compact('user', 'menus', 'allKategori', 'jumlah_item', 'kategoriList'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'extra_topping' => 'nullable|boolean',
        ]);

        $menu = Menu::findOrFail($request->menu_id);
        $businessId = Auth::user()->id_business;
        $harga = $menu->harga;
        $extraTopping = $request->extra_topping ? true : false;

        if ($extraTopping) {
            $harga += 3000;
        }

        $keranjang = Keranjang::where('menu_id', $request->menu_id)
            ->where('business_id', $businessId)
            ->where('extra_topping', $extraTopping)
            ->first();

        if ($keranjang) {
            $keranjang->jumlah++;
            $keranjang->total_harga = $keranjang->jumlah * $harga;
            $keranjang->save();
        } else {
            Keranjang::create([
                'menu_id' => $request->menu_id,
                'jumlah' => 1,
                'harga_satuan' => $harga,
                'total_harga' => $harga,
                'business_id' => $businessId,
                'extra_topping' => $extraTopping,
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

    public function updateQuantity(Request $request, $id)
    {
        $keranjang = Keranjang::with('menu')->findOrFail($id);

        $harga = 0;

        if ($keranjang->menu) {
            if ($keranjang->ukuran) {
                $size = Size::where('ukuran', $keranjang->ukuran)->first();
                if ($size) {
                    $sizePrice = SizePrice::where('menu_id', $keranjang->menu_id)
                        ->where('size_id', $size->id)
                        ->first();
                    if ($sizePrice) {
                        $harga = $sizePrice->harga;
                    } else {
                        $harga = $keranjang->menu->harga;
                    }
                } else {
                    $harga = $keranjang->menu->harga;
                }
            } else {
                $harga = $keranjang->menu->harga;
            }
        }

        $keranjang->jumlah += $request->action == 'increment' ? 1 : ($keranjang->jumlah > 1 ? -1 : 0);
        $keranjang->total_harga = $keranjang->jumlah * $harga;
        $keranjang->save();

        $totalBayar = Keranjang::sum('total_harga');

        return response()->json([
            'success' => true,
            'jumlah_baru' => $keranjang->jumlah,
            'total_harga_formatted' => number_format($keranjang->total_harga, 0, ',', '.'),
            'total_bayar_formatted' => number_format($totalBayar, 0, ',', '.')
        ]);
    }
}
