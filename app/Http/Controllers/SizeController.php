<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;
use App\Models\Business;
use App\Models\Category;
use App\Models\Size;
use App\Models\SizePrice;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datanama = "ukuran";
        $businesses = Business::get();
        $sizes = Size::with(['sizePrices'])->get();
        $sizePrices = SizePrice::with(['category'])->get();
        $categories = Category::all();
        return view('admin.manage-size.index', compact('sizes', 'datanama', 'businesses', 'sizePrices', 'categories'));
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
    public function store(StoreSizeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
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
            'harga' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $size = Size::findOrFail($id);
        $size->nama = $request->nama;
        $size->save();

        // Ambil entri pertama dari relasi hasMany sizePrices
        $sizePrice = $size->sizePrices()->first();

        if ($sizePrice) {
            // Update entri pertama
            $sizePrice->update([
                'harga' => $request->harga,
                'category_id' => $request->category_id,
            ]);
        } else {
            // Tambah baru jika belum ada
            $size->sizePrices()->create([
                'harga' => $request->harga,
                'category_id' => $request->category_id,
            ]);
        }

        return redirect()->back()->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $size = size::findOrFail($id);
        $size->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus.');
    }
}
