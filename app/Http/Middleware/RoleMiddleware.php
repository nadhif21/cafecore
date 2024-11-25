<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Pastikan pengguna terautentikasi
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Pastikan peran pengguna sesuai
        if (Auth::user()->role !== $role) {
            // Redirect sesuai peran pengguna
            if (Auth::user()->role === 'user') {
                return redirect()->route('user.catalog');
            } elseif (Auth::user()->role === 'admin') {
                return redirect()->route('admin.home');
            }

            // Jika peran tidak dikenali
            abort(403, 'You do not have access to this resource.');
        }

        return $next($request);
    }
}
