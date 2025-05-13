<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Size;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ManageMenuController extends Controller
{
    public function index(Request $request)
    {
        $usahaId = $request->input('usaha_id');
        $kategoriId = $request->input('kategori_id');
        $datanama = "menu";

        $businesses = $this->getAllBusinesses();
        $categories = $this->getCategoriesByBusiness($usahaId);
        $menus = $this->getFilteredMenus($usahaId, $kategoriId);

        return view('admin.manage-menu.index', compact('businesses', 'categories', 'menus', 'usahaId', 'kategoriId', 'datanama'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_id' => 'required|exists:business,id',
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'foto' => 'required|image|mimes:jpeg,png,jpg,heic|max:5120',
        ]);

        $foto = $request->file('foto');
        $namaMenu = Str::slug($request->nama);
        $namaFile = $namaMenu . '-' . time() . '.' . $foto->getClientOriginalExtension();
        $fotoPath = $foto->move(public_path('img/upload'), $namaFile);

        Menu::create([
            'business_id' => $request->business_id,
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
            'harga' => $request->harga,
            'foto' => 'img/upload/' . $namaFile,
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan.');
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'business_id' => 'required|exists:business,id',
            'super_kategori_id' => 'nullable|exists:super_categories,id',
            'nama' => 'required|string|max:255',
        ]);

        Category::create([
            'business_id' => $request->business_id,
            'super_kategori_id' => $request->super_kategori_id,
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function getKategoriByBusiness($id)
    {
        $categories = Category::where('business_id', $id)->get();
        return response()->json($categories);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'business_id' => 'required|exists:business,id',
            'kategori_id' => 'required|exists:categories,id',
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,heic|max:5120',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->business_id = $request->business_id;
        $menu->kategori_id = $request->kategori_id;
        $menu->nama = $request->nama;
        $menu->harga = $request->harga;

        if ($request->hasFile('foto')) {
            if ($menu->foto && file_exists(public_path($menu->foto))) {
                unlink(public_path($menu->foto));
            }

            $foto = $request->file('foto');
            $namaMenu = Str::slug($request->nama);
            $namaFile = $namaMenu . '-' . time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('img/upload'), $namaFile);
            $menu->foto = 'img/upload/' . $namaFile;
        }

        $menu->save();

        return redirect()->back()->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->foto && File::exists(public_path($menu->foto))) {
            File::delete(public_path($menu->foto));
        }

        $menu->delete();

        return redirect()->back()->with('success', 'Menu dan fotonya berhasil dihapus.');
    }

    private function getAllBusinesses()
    {
        return Business::get();
    }

    private function getCategoriesByBusiness($usahaId = null)
    {
        if ($usahaId) {
            return Category::where('business_id', $usahaId)->get();
        }

        return Category::get();
    }

    private function getFilteredMenus($usahaId = null, $kategoriId = null)
    {
        return Menu::with(['business', 'category'])
            ->when($usahaId, function ($query) use ($usahaId) {
                $query->where('business_id', $usahaId);
            })
            ->when($kategoriId, function ($query) use ($kategoriId) {
                $query->where('kategori_id', $kategoriId);
            })

            ->get();
    }
}
