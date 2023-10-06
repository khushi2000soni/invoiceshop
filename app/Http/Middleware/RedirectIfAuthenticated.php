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
    public function handle(Request $request, Closure $next,  $guard = null): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        if (Auth::guard($guard)->check()) {
            if (Auth::user()->is_admin || Auth::user()->is_accountant || Auth::user()->is_staff){
                return redirect('dashboard');
            } else {
                abort(403, 'Unauthorized');
            }

        }

        return $next($request);
    }
}
