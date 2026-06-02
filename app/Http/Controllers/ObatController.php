<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;

class ObatController extends Controller
{
    public function index() {
        $obat = Obat::orderBy('nama_obat', 'asc')->get();
        $jml_kritis = Obat::where('stok', '<=', 10)->count();
        return view('obat.index', compact('obat', 'jml_kritis'));
    }
    public function create() {
        $jml_kritis = Obat::where('stok', '<=', 15)->count();
        return view('obat.create', compact('jml_kritis'));
    }
    public function store(Request $request) {
        Obat::create($request->all());
        return redirect('/obat')->with('success', 'Obat berhasil ditambahkan!');
    }
    public function edit($id) {
        $obat = Obat::findOrFail($id);
        return view('obat.edit', compact('obat'));
    }
    public function update(Request $request, $id) {
        Obat::findOrFail($id)->update($request->all());
        return redirect('/obat')->with('success', 'Data obat diperbarui!');
    }
    public function destroy($id)
        {
            $obat = Obat::findOrFail($id);
            
            // Hapus data obat
            $obat->delete();

            return redirect('/obat')->with('success', 'Data obat berhasil dihapus permanen!');
        }
}