<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Menu;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        $keranjang = Keranjang::where('menu_id', $request->menu_id)->first();

        if ($keranjang) {
            $keranjang->jumlah += 1;
            $keranjang->total_harga = $keranjang->jumlah * $menu->harga;
            $keranjang->save();
        } else {
            Keranjang::create([
                'menu_id' => $request->menu_id,
                'jumlah' => 1,
                'total_harga' => $menu->harga,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function viewCart()
    {
        $keranjangs = Keranjang::with('menu')->get();
        return view('pegawai.keranjang.index', compact('keranjangs'));
    }

    public function removeFromCart($id)
    {
        $keranjang = Keranjang::findOrFail($id);
        $keranjang->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
