<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Size;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Http\Request;

class ManageMenuController extends Controller
{
    public function index()
    {
        $dataName = "Menu";
        $businesses = Business::get();
        $categories = Category::get();
        $menus = Menu::with(['business', 'kategori'])->get();

        return view('admin.manage-menu.index', compact('businesses', 'categories', 'menus', "dataName"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_id' => 'required|exists:business,id',
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
        ]);

        // dd($request->all());
        Menu::create([
            'business_id' => $request->business_id,
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
            'harga' => $request->harga,
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan.');
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'business_id' => 'required|exists:business,id',
            'nama' => 'required|string|max:255',
        ]);

        Category::create([
            'business_id' => $request->business_id,
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function getKategoriByBusiness($id)
    {
        $categories = Category::where('business_id', $id)->get();
        return response()->json($categories);
    }

    public function ukuranStore(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $ukuran = new Size();
        $ukuran->menu_id = $request->menu_id;
        $ukuran->nama = $request->nama;
        $ukuran->harga = $request->harga;

        if ($ukuran->save()) {
            return redirect()->back()->with('success', 'Ukuran berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan ukuran.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->nama = $request->nama;
        $menu->harga = $request->harga;
        $menu->save();

        return redirect()->back()->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus.');
    }
}
