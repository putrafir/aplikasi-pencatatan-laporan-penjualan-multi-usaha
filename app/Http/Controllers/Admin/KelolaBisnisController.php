<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class KelolaBisnisController extends Controller
{
    public function index()

    {
        $business = Business::withCount(['menus', 'users'])->get();
        return view('admin.kelola-bisnis.index', compact('business'));
    }

    public function kelola($id)
    {
        $business = Business::withCount(['menus', 'stocks', 'users', 'categories'])->findOrFail($id);

        $perPage = 5;
        $currentPage = request()->get('page', 1); // ambil query string ?page=...
        $allStocks = $business->stocks; // Collection

        $total = $allStocks->count();
        $stocks = $allStocks->slice(($currentPage - 1) * $perPage, $perPage)->values();

        
        return view('admin.kelola-bisnis.kelola', compact('business', 'stocks', 'total', 'perPage',  'currentPage'));
    }
}
