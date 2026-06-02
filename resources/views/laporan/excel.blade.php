<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan PharmaPOS</title>
    <style>
        /* Styling Khusus untuk Excel */
        .header-title {
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bg-primary { 
            background-color: #1e293b; 
            color: #ffffff; 
            font-weight: bold; 
        }
        .bg-light { background-color: #f8fafc; }
        .border-all { border: 1px solid #000000; }
        .currency { mso-number-format:"\#\,\#\#0"; } /* Format angka Excel agar ribuan dipisah koma/titik */
    </style>
</head>
<body>

    <table>
        <tr>
            <td colspan="7" class="header-title">LAPORAN PENJUALAN APOTEK PHARMAPOS</td>
        </tr>
        <tr>
            <td colspan="7" class="text-center">
                Periode: {{ request('tgl') ? \Carbon\Carbon::parse(request('tgl'))->format('d F Y') : 'Semua Waktu' }}
            </td>
        </tr>
        <tr>
            <td colspan="7" class="text-center">Dicetak pada: {{ date('d/m/Y H:i:s') }} WIB</td>
        </tr>
        <tr><td></td></tr> </table>

    <table class="border-all">
        <thead>
            <tr>
                <th class="bg-primary border-all" width="5">NO</th>
                <th class="bg-primary border-all" width="20">ID TRANSAKSI</th>
                <th class="bg-primary border-all" width="25">TANGGAL & WAKTU</th>
                <th class="bg-primary border-all" width="15">METODE</th>
                <th class="bg-primary border-all" width="15">PPN (Rp)</th>
                <th class="bg-primary border-all" width="15">DISKON (Rp)</th>
                <th class="bg-primary border-all" width="20">TOTAL AKHIR (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($data as $key => $d)
            @php $grandTotal += $d->total_akhir; @endphp
            <tr>
                <td class="text-center border-all">{{ $key + 1 }}</td>
                <td class="text-center border-all">#TRX-{{ str_pad($d->id_transaksi, 4, '0', STR_PAD_LEFT) }}</td>
                <td class="border-all">{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y H:i') }}</td>
                <td class="text-center border-all">{{ strtoupper($d->metode) }}</td>
                <td class="text-right border-all currency">{{ $d->ppn }}</td>
                <td class="text-right border-all currency">{{ $d->diskon }}</td>
                <td class="text-right border-all currency fw-bold" style="background-color: #f1f5f9;">{{ $d->total_akhir }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-primary">
                <td colspan="6" class="text-right border-all" style="color: white; font-weight: bold;">TOTAL PENDAPATAN</td>
                <td class="text-right border-all currency" style="color: white; font-weight: bold;">{{ $grandTotal }}</td>
            </tr>
        </tfoot>
    </table>

    <table>
        <tr><td></td></tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" class="text-center small">Dicetak secara otomatis oleh sistem PharmaPOS</td>
        </tr>
    </table>

</body>
</html>