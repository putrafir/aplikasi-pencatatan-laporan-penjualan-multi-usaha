<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ManageCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'business_id' => 'required|exists:business,id',
        ]);

        $kategori = Category::findOrFail($id);
        $kategori->nama = $request->nama;
        $kategori->business_id = $request->business_id;
        $kategori->save();

        return redirect()->back()->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Category::findOrFail($id);
        $menu->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus.');
    }
}
