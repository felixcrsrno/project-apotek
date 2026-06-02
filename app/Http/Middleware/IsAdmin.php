<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN role-nya adalah 'admin'
        if (Auth::check() && Auth::user()->role == 'admin') {
            // Jika ya, izinkan akses ke halaman yang dituju
            return $next($request);
        }

        // Jika bukan admin (misal: kasir), tendang kembali ke dashboard
        return redirect('/dashboard')->with('error', 'Akses Ditolak! Halaman Manajemen User hanya untuk Administrator.');
    }
}