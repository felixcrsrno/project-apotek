<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\Obat;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Filter Tanggal (Default 30 hari terakhir)
        $tgl_mulai = $request->tgl_mulai ?? now()->subDays(30)->format('Y-m-d');
        $tgl_selesai = $request->tgl_selesai ?? now()->format('Y-m-d');

        // 2. Statistik Utama (Presisi Jam)
        $total = Transaksi::whereBetween('tanggal', [$tgl_mulai . ' 00:00:00', $tgl_selesai . ' 23:59:59'])->sum('total_akhir');
        $trx = Transaksi::whereBetween('tanggal', [$tgl_mulai . ' 00:00:00', $tgl_selesai . ' 23:59:59'])->count();
        
        // AMBIL SEMUA OBAT KRITIS (Urutan: Stok 0 paling atas)
        $list_kritis = Obat::where('stok', '<=', 15)
            ->orderBy('stok', 'asc') 
            ->get();
        $jml_kritis = $list_kritis->count();

        // 3. Data Tren Harian (Line Chart)
        $tren_harian = Transaksi::whereBetween('tanggal', [$tgl_mulai . ' 00:00:00', $tgl_selesai . ' 23:59:59'])
            ->selectRaw('DATE(tanggal) as tgl, SUM(total_akhir) as total, COUNT(*) as jumlah')
            ->groupBy('tgl')
            ->orderBy('tgl', 'asc')
            ->get();

        $tgl_labels = $tren_harian->pluck('tgl')->map(fn($t) => Carbon::parse($t)->format('d M'));
        $total_harian = $tren_harian->pluck('total');

        // 3a. Data Transaksi Per Hari Lengkap (Untuk Tabel)
        $transaksi_per_hari = $tren_harian->map(function($item) {
            return [
                'tanggal' => Carbon::parse($item->tgl)->format('d M Y'),
                'hari' => Carbon::parse($item->tgl)->format('l'),
                'jumlah' => $item->jumlah,
                'total' => $item->total,
                'rata_rata' => $item->jumlah > 0 ? round($item->total / $item->jumlah) : 0
            ];
        })->reverse();

        // 3b. Data Per Jam (Untuk Melihat Jam-jam Sibuk)
        $transaksi_per_jam = Transaksi::whereBetween('tanggal', [$tgl_mulai . ' 00:00:00', $tgl_selesai . ' 23:59:59'])
            ->selectRaw('HOUR(tanggal) as jam, COUNT(*) as jumlah, SUM(total_akhir) as total')
            ->groupBy('jam')
            ->orderBy('jam', 'asc')
            ->get();

        $jam_labels = [];
        $jam_count = [];
        for ($i = 0; $i < 24; $i++) {
            $jam_labels[] = sprintf('%02d:00', $i);
            $jam_data = $transaksi_per_jam->where('jam', $i)->first();
            $jam_count[] = $jam_data ? $jam_data->jumlah : 0;
        }

        // Hitung rata-rata per hari
        $hari_count = Carbon::parse($tgl_selesai)->diffInDays(Carbon::parse($tgl_mulai)) + 1;
        $rata_rata_per_hari = $trx > 0 ? round($trx / max(1, $hari_count)) : 0;
        $rata_rata_trx = $trx > 0 ? round($total / $trx) : 0;

        // 4. Data Metode Pembayaran (Doughnut Chart)
        $metode_data = Transaksi::whereBetween('tanggal', [$tgl_mulai . ' 00:00:00', $tgl_selesai . ' 23:59:59'])
            ->selectRaw('metode, COUNT(*) as count')
            ->groupBy('metode')
            ->get();

        $labels_metode = $metode_data->pluck('metode');
        $data_metode = $metode_data->pluck('count');

        // 5. Data Obat Terlaris (Bar Chart)
        $obat_terlaris = DB::table('detail_transaksi')
            ->join('obat', 'detail_transaksi.id_obat', '=', 'obat.id_obat')
            ->join('transaksi', 'detail_transaksi.id_transaksi', '=', 'transaksi.id_transaksi')
            ->whereBetween('transaksi.tanggal', [$tgl_mulai . ' 00:00:00', $tgl_selesai . ' 23:59:59'])
            ->selectRaw('obat.nama_obat, SUM(detail_transaksi.jumlah) as total_terjual')
            ->groupBy('obat.id_obat', 'obat.nama_obat')
            ->orderBy('total_terjual', 'desc')
            ->limit(5)
            ->get();

        $labels_obat = $obat_terlaris->pluck('nama_obat');
        $data_obat = $obat_terlaris->pluck('total_terjual');

        // Hitung trend dengan periode sebelumnya
        $tgl_mulai_prev = Carbon::parse($tgl_mulai)->subDays($hari_count)->format('Y-m-d');
        $tgl_selesai_prev = Carbon::parse($tgl_mulai)->subDay()->format('Y-m-d');
        
        $total_prev = Transaksi::whereBetween('tanggal', [$tgl_mulai_prev . ' 00:00:00', $tgl_selesai_prev . ' 23:59:59'])->sum('total_akhir');
        $trx_prev = Transaksi::whereBetween('tanggal', [$tgl_mulai_prev . ' 00:00:00', $tgl_selesai_prev . ' 23:59:59'])->count();

        $trend_total = $total_prev > 0 ? (($total - $total_prev) / $total_prev * 100) : 0;
        $trend_trx = $trx_prev > 0 ? (($trx - $trx_prev) / $trx_prev * 100) : 0;

        return view('dashboard.index', compact(
            'total', 'trx', 'jml_kritis', 'list_kritis', 
            'tgl_mulai', 'tgl_selesai', 'tgl_labels', 
            'total_harian', 'labels_metode', 'data_metode',
            'labels_obat', 'data_obat', 'rata_rata_trx', 'rata_rata_per_hari',
            'transaksi_per_hari', 'jam_labels', 'jam_count', 
            'trend_total', 'trend_trx'
        ));
    }
}