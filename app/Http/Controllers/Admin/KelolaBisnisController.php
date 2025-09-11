<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class KelolaBisnisController extends Controller
{
    public function index()

    {
        $business = Business::all();
        return view('admin.kelola-bisnis.index', compact('business'));
    }
}
