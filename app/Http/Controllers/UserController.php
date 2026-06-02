<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Obat;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Tarik data user dan urutkan berdasarkan role
        $users = User::orderBy('role', 'asc')->get();
        
        // Notifikasi stok kritis di Sidebar
        $jml_kritis = Obat::where('stok', '<=', 5)->count();

        return view('user.index', compact('users', 'jml_kritis'));
    }

    public function store(Request $request)
    {
        // Validasi input agar username tidak boleh sama (duplikat)
        $request->validate([
            'username' => 'required|unique:user,username',
            'password' => 'required|min:4',
            'role'     => 'required|in:admin,kasir'
        ]);

        // Simpan ke database (Password otomatis dienkripsi dengan Hash bawaan Laravel)
        User::create([
            'name'     => $request->username, // Default nama sama dengan username dulu
            'username' => $request->username,
            'password' => Hash::make($request->password), // Enkripsi password
            'role'     => $request->role,
        ]);

        return redirect('/user')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect('/user')->with('success', 'Pengguna berhasil dihapus!');
    }
}