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
            'username' => 'required|unique:user,username', // Sesuaikan jika nama tabel Anda 'users'
            'password' => 'required|min:4',
            'role'     => 'required|in:admin,kasir'
        ]);

        // Simpan ke database
        User::create([
            'name'     => $request->username, 
            'username' => $request->username,
            'password' => Hash::make($request->password), 
            'role'     => $request->role,
        ]);

        return redirect('/user')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        // Cari user berdasarkan ID / Primary Key
        $user = User::find($id);

        // Jika user tidak ditemukan, kembalikan pesan error alih-alih 404 halaman kosong
        if (!$user) {
            return redirect('/user')->with('error', 'Data pengguna tidak ditemukan atau sudah dihapus!');
        }

        // Proses hapus data
        $user->delete();

        return redirect('/user')->with('success', 'Pengguna berhasil dihapus!');
    }
}