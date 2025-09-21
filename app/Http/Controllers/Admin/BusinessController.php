<?php

namespace App\Http\Controllers\Admin;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusinessController extends Controller
{
    public function detailLaporan($id)
    {
        $usaha = Business::with(['stocks','transaksis'])->findOrFail($id);
        return view('admin.laporan.detailLaporan', compact('usaha'));
    }
}
