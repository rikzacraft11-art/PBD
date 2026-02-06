<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                // Jika login sebagai admin (guard: admin)
                if ($guard === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                // Jika login sebagai peserta (guard: web / default)
                if ($guard === 'web') {
                    return redirect()->route('portal.index');
                }

                // Default fallback jika guard lain
                return redirect('/');
            }
        }

        return $next($request);
    }
}
