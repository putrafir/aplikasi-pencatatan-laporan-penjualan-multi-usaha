<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $user = Auth::user();

        if (!$user->is_verified) {
            Auth::logout();
            return back()->with('warning', 'Akun anda belum diverifikasi oleh pemilik usaha.');
        }

        $request->session()->regenerate();

        return $this->redirectBasedOnRole($user->role, $user->id_business);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Redirect user based on their role.
     */
    protected function redirectBasedOnRole(string $role, ?int $id_business = null): RedirectResponse
    {
        if ($role === 'owner') {
            return redirect()->intended(route('owner.dashboard') . '?verified=1');
        }

        if ($role === 'pegawai') {
            if ($id_business == 2) {
                return redirect()->intended(route('pegawai.miss.home') . '?kategori=Miss%20Smoothies');
            } elseif ($id_business == 1) {
                return redirect()->intended(route('pegawai.pisgor.home') . '?kategori=Pisgor');
            }
        }

        // Default redirect if role is not matched
        return redirect()->intended(route('dashboard') . '?verified=1');
    }
}
