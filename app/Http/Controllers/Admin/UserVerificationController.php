<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserVerificationController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'owner')->orderBy('id', 'asc')->get();
        return view('admin.manage-user.verify-users', compact('users'));
    }

    public function verify(User $user)
    {
        $user->update(['is_verified' => true]);

        return back()->with('success', 'Akun berhasil diverifikasi.');
    }

    public function deleteUser($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();

        return redirect()->back()->with('success', 'Employee deleted successfully');
    }
}
