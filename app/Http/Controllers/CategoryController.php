<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $businesses = Business::get();
        $categories = Category::with(['business'])->get();
        $datanama = ('nama');

        return view('admin.manage-category.index', compact('businesses', 'categories'));
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
            'business_id' => 'required|exists:businesses,id',
        ]);

        $category = Category::findOrFail($id);
        $category->nama = $request->nama;
        $category->business_id = $request->business_id;
        $category->save();

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
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
