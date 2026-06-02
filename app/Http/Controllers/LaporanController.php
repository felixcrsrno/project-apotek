<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::query();
        if ($request->tgl) {
            $query->whereDate('tanggal', $request->tgl);
        }
        $transaksi = $query->orderBy('tanggal', 'desc')->get();

        $summary = [
            'total_transaksi' => $transaksi->count(),
            'total_pendapatan' => $transaksi->sum('total_akhir')
        ];

        return view('laporan.index', compact('transaksi', 'summary'));
    }

    public function exportExcel(Request $request)
    {
        $query = Transaksi::query();
        if ($request->tgl) {
            $query->whereDate('tanggal', $request->tgl);
        }
        $data = $query->orderBy('tanggal', 'desc')->get();

        // Nama file yang akan dihasilkan
        $fileName = "Laporan_Penjualan_" . date('Ymd_His') . ".xls";

        // Pengaturan Header agar browser mendownload file Excel
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Kirim data ke view khusus excel
        return view('laporan.excel', compact('data'));
    }
}