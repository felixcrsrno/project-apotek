<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Obat;
use App\Models\Supplier; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PembelianController extends Controller
{
    /**
     * Menampilkan daftar semua faktur pembelian
     */
    public function index()
    {
        $pembelian = Pembelian::with('supplier')->orderBy('tanggal', 'desc')->get();
        return view('pembelian.index', compact('pembelian'));
    }

    /**
     * Menampilkan form untuk menambah faktur baru
     */
    public function create()
    {
        $obat_array = Obat::orderBy('nama_obat', 'asc')->get();
        $supplier_array = Supplier::orderBy('nama_supplier', 'asc')->get(); 
        
        return view('pembelian.create', compact('obat_array', 'supplier_array'));
    }

    /**
     * Menyimpan data faktur baru, Update STOK dan Update HARGA OBAT
     */
    public function store(Request $request)
    {
        // ==========================================
        // SKENARIO GAGAL: Validasi Duplikasi No Faktur Saat Simpan Baru
        // ==========================================
        $request->validate([
            'no_faktur' => 'required|unique:pembelian,no_faktur', // Nama tabel disesuaikan 'pembelian'
        ], [
            'no_faktur.unique' => 'Gagal menyimpan! Nomor Faktur Supplier tersebut sudah pernah diinput sebelumnya.',
        ]);
        // ==========================================

        DB::transaction(function () use ($request) {
            // Sinkronisasi input form (mendukung total_bayar maupun total_faktur lama)
            $total_bayar = $request->total_bayar ?? $request->total_faktur;
            $harga_array = $request->harga_beli ?? $request->harga;

            // PERBAIKAN: Cek/Buat Supplier berdasarkan nama yang diinput manual
            $supplier = Supplier::firstOrCreate(
                ['nama_supplier' => $request->nama_supplier]
            );

            // 1. Simpan data faktur utama menggunakan id_supplier hasil firstOrCreate
            $pembelian = Pembelian::create([
                'no_faktur' => $request->no_faktur,
                'id_supplier' => $supplier->id_supplier, 
                'tanggal' => $request->tanggal,
                'total_bayar' => $total_bayar,
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            // 2. Simpan detail item
            if ($request->item_obat) {
                foreach ($request->item_obat as $key => $id_obat) {
                    $qty = $request->qty[$key];
                    $harga_satuan = $harga_array[$key];
                    $subtotal = $qty * $harga_satuan;

                    DetailPembelian::create([
                        'id_pembelian' => $pembelian->id_pembelian,
                        'id_obat' => $id_obat,
                        'qty' => $qty,
                        'harga_beli' => $harga_satuan,
                        'subtotal' => $subtotal,
                    ]);

                    // 3. Update Master Data Obat (Stok Bertambah & Harga Terupdate)
                    $obat = Obat::find($id_obat);
                    if ($obat) {
                        $obat->stok += $qty;
                        $obat->harga = $harga_satuan; 
                        $obat->save();
                    }
                }
            }
        });

        return redirect('/pembelian')->with('success', 'Faktur berhasil disimpan. Stok, Supplier, dan Harga Obat telah diperbarui!');
    }

    /**
     * Menampilkan form edit faktur
     */
    public function edit($id)
    {
        $faktur = Pembelian::findOrFail($id);
        $detail = DetailPembelian::where('id_pembelian', $id)->get();
        $obat_array = Obat::orderBy('nama_obat', 'asc')->get();
        $supplier_array = Supplier::orderBy('nama_supplier', 'asc')->get(); 

        return view('pembelian.edit', compact('faktur', 'detail', 'obat_array', 'supplier_array'));
    }

    /**
     * Mengupdate data faktur, Sinkronisasi STOK, dan Update HARGA OBAT
     */
    public function update(Request $request, $id)
    {
        // ==========================================
        // SKENARIO GAGAL: Validasi Duplikasi No Faktur Saat Update 
        // (Abaikan pengecekan jika nomor faktur tersebut milik data ini sendiri)
        // ==========================================
        $request->validate([
            'no_faktur' => 'required|unique:pembelian,no_faktur,' . $id . ',id_pembelian', 
        ], [
            'no_faktur.unique' => 'Gagal memperbarui! Nomor Faktur Supplier tersebut sudah digunakan oleh data lain.',
        ]);
        // ==========================================

        DB::transaction(function () use ($request, $id) {
            $faktur = Pembelian::findOrFail($id);
            
            // Sinkronisasi input form
            $total_bayar = $request->total_bayar ?? $request->total_faktur;
            $harga_array = $request->harga_beli ?? $request->harga;

            // 1. KEMBALIKAN STOK LAMA (Membatalkan input sebelumnya)
            $detailLama = DetailPembelian::where('id_pembelian', $id)->get();
            foreach ($detailLama as $itemLama) {
                $obat = Obat::find($itemLama->id_obat);
                if ($obat) {
                    $obat->stok -= $itemLama->qty;
                    $obat->save();
                }
            }

            // PERBAIKAN: Cek/Buat Supplier berdasarkan nama yang diinput manual saat edit
            $supplier = Supplier::firstOrCreate(
                ['nama_supplier' => $request->nama_supplier]
            );

            // 2. UPDATE DATA FAKTUR UTAMA menggunakan id_supplier hasil firstOrCreate
            $faktur->update([
                'no_faktur' => $request->no_faktur,
                'id_supplier' => $supplier->id_supplier,
                'tanggal' => $request->tanggal,
                'total_bayar' => $total_bayar,
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            // 3. HAPUS DETAIL LAMA
            DetailPembelian::where('id_pembelian', $id)->delete();

            // 4. SIMPAN DETAIL BARU & UPDATE STOK + HARGA BARU
            if ($request->item_obat) {
                foreach ($request->item_obat as $key => $id_obat) {
                    $qty = $request->qty[$key];
                    $harga_satuan = $harga_array[$key];
                    $subtotal = $qty * $harga_satuan;

                    DetailPembelian::create([
                        'id_pembelian' => $id,
                        'id_obat' => $id_obat,
                        'qty' => $qty,
                        'harga_beli' => $harga_satuan,
                        'subtotal' => $subtotal,
                    ]);

                    $obatBaru = Obat::find($id_obat);
                    if ($obatBaru) {
                        $obatBaru->stok += $qty;
                        $obatBaru->harga = $harga_satuan; 
                        $obatBaru->save();
                    }
                }
            }
        });

        return redirect('/pembelian')->with('success', 'Faktur berhasil diperbarui. Stok, Supplier, dan Harga Obat disinkronkan!');
    }

    /**
     * Menghapus data faktur, Mengembalikan STOK OBAT, dan Menghapus Detail Item
     */
    public function destroy($id)
    {
        // RULES: Hanya admin yang dapat menghapus faktur pembelian
        // Kasir tidak diperbolehkan delete
        if (Auth::user()->role !== 'admin') {
            return redirect('/pembelian')->with('error', 'Akses Ditolak! Hanya Administrator yang dapat menghapus faktur pembelian.');
        }

        DB::transaction(function () use ($id) {
            $faktur = Pembelian::findOrFail($id);

            // 1. KEMBALIKAN STOK OBAT (Kurangi stok master karena pembelian dibatalkan/dihapus)
            $detail = DetailPembelian::where('id_pembelian', $id)->get();
            foreach ($detail as $item) {
                $obat = Obat::find($item->id_obat);
                if ($obat) {
                    $obat->stok -= $item->qty; 
                    $obat->save();
                }
            }

            // 2. HAPUS DATA DETAIL & DATA FAKTUR UTAMA
            DetailPembelian::where('id_pembelian', $id)->delete();
            $faktur->delete();
        });

        return redirect('/pembelian')->with('success', 'Faktur pembelian berhasil dihapus dan stok obat telah disesuaikan kembali!');
    }
}