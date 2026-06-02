<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Obat;

class TransaksiController extends Controller
{
    // Menampilkan terminal kasir
    public function index()
    {
        $obat = Obat::where('stok', '>', 0)->orderBy('nama_obat', 'asc')->get();
        $jml_kritis = Obat::where('stok', '<=', 5)->count();
        $cart = session()->get('cart', []); 
        return view('transaksi.index', compact('obat', 'jml_kritis', 'cart'));
    }

    // Menambahkan obat ke keranjang (Session)
    public function store(Request $request)
    {
        $obat = Obat::find($request->id_obat);
        
        if (!$obat) {
            return redirect()->back()->with('error', 'Obat tidak ditemukan!');
        }

        $qtyDiminta = $request->qty ?? 1;
        if ($obat->stok < $qtyDiminta) {
            return redirect()->back()->with('error', 'Stok obat tidak mencukupi!');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$obat->id_obat])) {
            if (($cart[$obat->id_obat]['qty'] + $qtyDiminta) > $obat->stok) {
                 return redirect()->back()->with('error', 'Total permintaan melebihi sisa stok obat!');
            }
            $cart[$obat->id_obat]['qty'] += $qtyDiminta;
        } else {
            $cart[$obat->id_obat] = [
                "nama" => $obat->nama_obat,
                "qty" => $qtyDiminta,
                "harga" => $obat->harga
            ];
        }

        session()->put('cart', $cart);
        return redirect('/transaksi')->with('success', 'Berhasil ditambahkan ke keranjang.');
    }

    // Menghapus satu item dari keranjang
    public function destroyItem($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect('/transaksi');
    }

    // Mengosongkan seluruh keranjang
    public function clear()
    {
        session()->forget('cart'); 
        return redirect('/transaksi');
    }

    // Proses Checkout Kasir Terintegrasi Midtrans
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        if (!$cart) {
            return $request->expectsJson() 
                ? response()->json(['message' => 'Keranjang kosong!'], 400)
                : redirect('/transaksi')->with('error', 'Keranjang masih kosong!');
        }

        // Validasi input bayar hanya jika metode Tunai
        if ($request->metode === 'Tunai' && $request->bayar < $request->total_akhir) {
             return redirect('/transaksi')->with('error', 'Uang pembayaran kurang!');
        }

        // Simpan Transaksi & Detailnya
        $transaksi = DB::transaction(function () use ($request, $cart) {
            $trx = Transaksi::create([
                'tanggal' => now(), 
                'metode' => $request->metode ?? 'Tunai', 
                'bayar' => $request->bayar, 
                'total_akhir' => $request->total_akhir, 
                'kembalian' => $request->kembalian ?? 0, 
            ]);

            foreach ($cart as $id_obat => $item) {
                DetailTransaksi::create([
                    'id_transaksi' => $trx->id_transaksi, 
                    'id_obat' => $id_obat, 
                    'jumlah' => $item['qty'], 
                    'subtotal' => $item['harga'] * $item['qty'], 
                ]);

                // Kurangi Stok Obat
                $obat = Obat::find($id_obat);
                if ($obat) {
                    $obat->stok -= $item['qty'];
                    $obat->save();
                }
            }

            return $trx;
        });

        session()->forget('cart'); 

        // LOGIKA PEMBAYARAN MIDTRANS
        if ($request->metode === 'QRIS' || $request->metode === 'Transfer') {
            
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            \Midtrans\Config::$isProduction = false; 
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            // Menggunakan format array kurung siku [] untuk meminimalisir error kurung ()
            $params = [
                'transaction_details' => [
                    'order_id' => 'TRX-' . $transaksi->id_transaksi . '-' . time(), 
                    'gross_amount' => $transaksi->total_akhir,
                ],
                'customer_details' => [
                    'first_name' => 'Pelanggan',
                    'last_name' => 'Apotek PharmaPOS',
                ],
            ];

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                
                return response()->json([
                    'snap_token' => $snapToken,
                    'id_transaksi' => $transaksi->id_transaksi
                ]);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error Midtrans: ' . $e->getMessage()], 500);
            }
        }

        // LOGIKA PEMBAYARAN TUNAI
        return redirect('/transaksi/struk/' . $transaksi->id_transaksi);
    }

    // Tampilan Cetak Struk
    public function struk($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $detail = DetailTransaksi::where('id_transaksi', $id)->get(); 
        
        return view('transaksi.struk', compact('transaksi', 'detail'));
    }
}