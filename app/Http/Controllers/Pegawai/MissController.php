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
    public function index()
    {
        $user = Auth::user();
        $menus = Menu::where('business_id', 2)->get();
        return view('pegawai.Miss.index', compact('user', 'menus'));
    }
    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
        ]);

        $menu = Menu::findOrFail($request->menu_id);
        $businessId = Auth::user()->id_business;


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
                'business_id' => $businessId,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function viewCart()
    {
        $keranjangs = Keranjang::with('menu')->get();
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

        // Ambil semua item keranjang
        $keranjangs = Keranjang::all();

        if ($keranjangs->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong, tidak ada yang bisa dibayar.');
        }

        // Hitung total pembayaran
        $totalBayar = $keranjangs->sum('total_harga');

        // Validasi apakah uang yang dibayarkan cukup
        if ($request->uang_dibayarkan < $totalBayar) {
            return redirect()->back()->with('error', 'Uang yang dibayarkan tidak cukup.');
        }

        // Hitung kembalian
        $kembalian = $request->uang_dibayarkan - $totalBayar;

        // Ambil `business_id` dari pengguna yang sedang login
        $businessId = Auth::user()->id_business;

        // Simpan detail produk dalam bentuk array
        $details = $keranjangs->map(function ($keranjang) {
            return [
                'menu_id' => $keranjang->menu_id,
                'nama' => $keranjang->menu->nama,
                'jumlah' => $keranjang->jumlah,
                'harga' => $keranjang->menu->harga,
                'subtotal' => $keranjang->total_harga,
            ];
        });

        // Simpan transaksi ke tabel `transaksis`
        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'business_id' => $businessId, // Isi otomatis berdasarkan bisnis pengguna
            'total_bayar' => $totalBayar,
            'uang_dibayarkan' => $request->uang_dibayarkan,
            'kembalian' => $kembalian,
            'details' => $details->toJson(),
        ]);

        // Kosongkan tabel keranjang
        Keranjang::truncate();

        return redirect()->back()->with('success', "Pembayaran berhasil. Uang yang di bayarkan: Rp " . number_format($request->uang_dibayarkan, 0, ',', '.') . ". Kembalian: Rp " . number_format($kembalian, 0, ',', '.'));
    }
}
