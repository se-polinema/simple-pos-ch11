<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Revoke access for an already-logged-in session/token whose account was
     * deactivated mid-session (login itself is guarded separately — see
     * LoginController and Api\AuthController).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->is_active) {
            if ($request->is('api/*') || $request->expectsJson()) {
                abort(403, 'Akun dinonaktifkan.');
            }

            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun dinonaktifkan. Hubungi admin.',
            ]);
        }

        return $next($request);
    }
}
