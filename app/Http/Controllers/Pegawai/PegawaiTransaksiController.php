<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiTransaksiController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        $categories = Category::where('business_id', $user->id_business)->get();

        return view('pegawai.transaksi.index', compact('categories'));
    }

    public function getAllMenus()
    {
        $user = Auth::user();
        $menus = Menu::whereHas('category', function ($query) use ($user) {
            $query->where('business_id', $user->id_business);
        })->get();

        return response()->json(['menus' => $menus]);
    }

    public function getMenus($kategoriId)
    {
        $user = Auth::user();

        $menus = Menu::with(['category.sizePrices.size'])
            ->where('kategori_id', $kategoriId)
            ->whereHas('category', function ($query) use ($user) {
                $query->where('business_id', $user->id_business);
            })
            ->get()
            ->map(function ($menu) {
                return [
                    'id' => $menu->id,
                    'nama' => $menu->nama,
                    'deskripsi' => $menu->deskripsi,
                    'harga' => $menu->harga,
                    'sizePrices' => $menu->category->sizePrices->map(function ($sp) {
                        return [
                            'size' => [
                                'nama' => $sp->size->nama
                            ],
                            'harga' => $sp->harga
                        ];
                    })
                ];
            });

        return response()->json([
            'menus' => $menus
        ]);
    }
}
