<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Business;
use App\Models\Category;
use App\Models\SuperCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $businesses = Business::get();
        $superCategories = SuperCategory::get();
        $categories = Category::with(['business','superKategori'])->get();
        $datanama = "kategori";

        return view('admin.manage-category.index', compact('businesses', 'categories', 'datanama', 'superCategories'));
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
    public function store(StoreCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
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
    public function destroy($id)
    {
        $menu = Category::findOrFail($id);
        $menu->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus.');
    }
}
