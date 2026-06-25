<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CanDeletePembelian
{
    /**
     * Handle an incoming request.
     * 
     * RULES: Hanya ADMIN yang dapat menghapus faktur pembelian.
     * Kasir dilarang menghapus faktur pembelian meskipun dapat akses halaman.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah role user adalah 'admin'
        if (Auth::user()->role !== 'admin') {
            return redirect('/pembelian')->with('error', 'Akses Ditolak! Hanya Administrator yang dapat menghapus faktur pembelian.');
        }

        return $next($request);
    }
}
