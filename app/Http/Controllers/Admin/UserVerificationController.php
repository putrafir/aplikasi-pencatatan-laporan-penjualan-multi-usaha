<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class UserVerificationController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'owner')->orderBy('id', 'asc')->get();
        $businesses = Business::all();
        return view('admin.manage-user.verify-users', compact('users', 'businesses'));
    }

    public function addUser(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', Rules\Password::defaults()],
            'id_business' => ['required', 'exists:business,id'],
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'pegawai',
            'is_verified' => true,
            'password' => Hash::make($request->password),
            'id_business' => $request->id_business,
        ]);


        event(new Registered($user));


        return back()->with('success', 'Akun berhasil di tambahkan.');
    }

    public function verify(User $user)
    {
        $user->update(['is_verified' => true]);

        return back()->with('success', 'Akun berhasil di verifikasi.');
    }

    public function inverify(User $user)
    {
        $user->update(['is_verified' => false]);

        return back()->with('success', 'Akun berhasil di inverifikasi.');
    }

    public function deleteUser($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();

        return redirect()->back()->with('success', 'Employee deleted successfully');
    }
}
