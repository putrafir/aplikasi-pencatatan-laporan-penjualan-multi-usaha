<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use Illuminate\Http\Request;

class ManageStokController extends Controller
{
    public function index(Request $request)
    {
        $bahans = Bahan::get();

        return view('admin.manage-bahan.index', compact('bahans'));
    }

    public function destroy($id)
    {
        $bahan = Bahan::findOrFail($id);
        $bahan->delete();

        return redirect()->back()->with('success', 'Bahan berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
        ]);

        $bahan = Bahan::findOrFail($id);
        $bahan->nama_bahan = $request->nama_bahan;
        $bahan->save();

        return redirect()->back()->with('success', 'Menu berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
        ]);

        // dd($request->all());
        Bahan::create([
            'nama_bahan' => $request->nama_bahan,
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan.');
    }
}
