<?php

// 1. KOREKSI: Namespace harus menyertakan folder \Auth
namespace App\Http\Controllers\Auth;

// 2. KOREKSI: Panggil Controller utama karena sekarang berada di sub-folder
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        // Jika sudah login, lempar ke dashboard
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Proses Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Laravel otomatis menyimpan data user ke Auth::user()
            // Baris session(['username' => ...]) sebenarnya opsional di Laravel
            session(['username' => Auth::user()->username]); 

            return redirect()->intended('/dashboard');
        }

        // Jika gagal, kembali ke login dengan notifikasi (SweetAlert di layout akan membaca ini)
        return back()->with('error', 'Username atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->forget('username');
        
        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}