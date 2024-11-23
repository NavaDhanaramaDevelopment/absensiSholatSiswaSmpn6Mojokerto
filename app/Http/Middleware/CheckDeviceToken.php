<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDeviceToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Jika token perangkat tidak cocok, logout dan arahkan ke login
            if ($request->session()->get('device_token') != $user->device_token) {
                Auth::logout();
                return redirect('login')->with('alert', 'Akun ini telah digunakan di perangkat lain.');
            }
        }

        return $next($request);
    }
}
