<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Obat;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    /**
     * Menampilkan daftar semua faktur pembelian
     */
    public function index()
    {
        $pembelian = Pembelian::orderBy('tanggal', 'desc')->get();
        return view('pembelian.index', compact('pembelian'));
    }

    /**
     * Menampilkan form untuk menambah faktur baru
     */
    public function create()
    {
        $obat_array = Obat::orderBy('nama_obat', 'asc')->get();
        // NAMA VIEW DIUBAH MENJADI 'create'
        return view('pembelian.create', compact('obat_array'));
    }

    /**
     * Menyimpan data faktur baru, Update STOK dan Update HARGA OBAT
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            // 1. Simpan data faktur utama
            $pembelian = Pembelian::create([
                'no_faktur' => $request->no_faktur,
                'nama_supplier' => $request->nama_supplier,
                'tanggal' => $request->tanggal,
                'total_bayar' => $request->total_faktur,
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            // 2. Simpan detail item
            if ($request->item_obat) {
                foreach ($request->item_obat as $key => $id_obat) {
                    DetailPembelian::create([
                        'id_pembelian' => $pembelian->id_pembelian,
                        'id_obat' => $id_obat,
                        'qty' => $request->qty[$key],
                        'harga_beli' => $request->harga[$key],
                        'subtotal' => $request->qty[$key] * $request->harga[$key],
                    ]);

                    // 3. Update Master Data Obat (Stok Bertambah & Harga Terupdate)
                    $obat = Obat::find($id_obat);
                    if ($obat) {
                        $obat->stok += $request->qty[$key];
                        $obat->harga = $request->harga[$key]; // Mengupdate harga obat ke harga beli terbaru
                        $obat->save();
                    }
                }
            }
        });

        return redirect('/pembelian')->with('success', 'Faktur berhasil disimpan. Stok dan Harga Obat telah diperbarui!');
    }

    /**
     * Menampilkan form edit faktur
     */
    public function edit($id)
    {
        $faktur = Pembelian::findOrFail($id);
        $detail = DetailPembelian::where('id_pembelian', $id)->get();
        $obat_array = Obat::orderBy('nama_obat', 'asc')->get();

        return view('pembelian.edit', compact('faktur', 'detail', 'obat_array'));
    }

    /**
     * Mengupdate data faktur, Sinkronisasi STOK, dan Update HARGA OBAT
     */
    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $faktur = Pembelian::findOrFail($id);

            // 1. KEMBALIKAN STOK LAMA (Membatalkan input sebelumnya)
            $detailLama = DetailPembelian::where('id_pembelian', $id)->get();
            foreach ($detailLama as $itemLama) {
                $obat = Obat::find($itemLama->id_obat);
                if ($obat) {
                    $obat->stok -= $itemLama->qty;
                    $obat->save();
                }
            }

            // 2. UPDATE DATA FAKTUR UTAMA
            $faktur->update([
                'no_faktur' => $request->no_faktur,
                'nama_supplier' => $request->nama_supplier,
                'tanggal' => $request->tanggal,
                'total_bayar' => $request->total_faktur,
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            // 3. HAPUS DETAIL LAMA
            DetailPembelian::where('id_pembelian', $id)->delete();

            // 4. SIMPAN DETAIL BARU & UPDATE STOK + HARGA BARU
            if ($request->item_obat) {
                foreach ($request->item_obat as $key => $id_obat) {
                    DetailPembelian::create([
                        'id_pembelian' => $id,
                        'id_obat' => $id_obat,
                        'qty' => $request->qty[$key],
                        'harga_beli' => $request->harga[$key],
                        'subtotal' => $request->qty[$key] * $request->harga[$key],
                    ]);

                    $obatBaru = Obat::find($id_obat);
                    if ($obatBaru) {
                        $obatBaru->stok += $request->qty[$key];
                        $obatBaru->harga = $request->harga[$key]; // Update ke harga baru dari form edit
                        $obatBaru->save();
                    }
                }
            }
        });

        return redirect('/pembelian')->with('success', 'Faktur berhasil diperbarui. Stok dan Harga Obat disinkronkan!');
    }
}