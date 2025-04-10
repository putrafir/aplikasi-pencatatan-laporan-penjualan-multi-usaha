<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class ManageMenuController extends Controller
{
    public function index()
    {
        $businesses = Business::get();
        $categories = Category::get();
        return view('admin.manage-menu.index', compact('businesses', 'categories'));
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

    public function categorStore(Request $request)
    {
        $request->validate([
            'business_id' => 'required|exists:business,id',
            'nama' => 'required|string|max:255',
        ]);

        Menu::create([
            'business_id' => $request->business_id,
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan.');
    }

    public function getKategoriByBusiness($id)
    {
        $categories = Category::where('business_id', $id)->get();
        return response()->json($categories);
    }
}
