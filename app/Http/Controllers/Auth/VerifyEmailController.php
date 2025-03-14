<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectBasedOnRole($request->user()->role);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->redirectBasedOnRole($request->user()->role);
    }

    /**
     * Redirect user based on their role.
     */
    protected function redirectBasedOnRole(string $role): RedirectResponse
    {
        if ($role === 'owner') {
            return redirect()->intended(route('owner.dashboard') . '?verified=1');
        }

        if ($role === 'pegawai') {
            return redirect()->intended(route('pegawai.dashboard') . '?verified=1');
        }

        // Default redirect if role is not matched
        return redirect()->intended(route('dashboard') . '?verified=1');
    }
}
