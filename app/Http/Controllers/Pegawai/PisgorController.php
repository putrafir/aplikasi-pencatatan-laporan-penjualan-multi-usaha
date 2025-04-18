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
}
