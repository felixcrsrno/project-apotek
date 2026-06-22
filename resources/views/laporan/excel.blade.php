<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan PharmaPOS</title>
    <style>
        /* Styling Khusus untuk Excel */
        body {
            font-family: Arial, sans-serif;
            color: #334155;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            text-align: center;
            vertical-align: middle;
            height: 25px;
        }
        td {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            vertical-align: middle;
            height: 22px;
        }
        .header-title {
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
            color: #0f172a;
        }
        .header-subtitle {
            font-size: 11pt;
            text-align: center;
            color: #475569;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .bg-header { 
            background-color: #0f172a; 
            color: #ffffff; 
            font-weight: bold; 
        }
        .bg-zebra { 
            background-color: #f8fafc; 
        }
        .bg-total {
            background-color: #cbd5e1;
            font-weight: bold;
            color: #0f172a;
        }
        .border-all { 
            border: 1px solid #94a3b8; 
        }
        /* Format angka Excel: Ribuan dipisah titik, tanpa desimal */
        .currency { 
            mso-number-format:"\#\,\#\#0"; 
        }
        /* Format text agar ID tidak berubah menjadi format ilmiah/tanggal otomatis */
        .text-format {
            mso-number-format:"\@";
        }
    </style>
</head>
<body>

    <table>
        <tr>
            <td colspan="5" class="header-title">LAPORAN PENJUALAN APOTEK ALFATIH</td>
        </tr>
        <tr>
            <td colspan="5" class="header-subtitle">
                Periode: {{ request('tgl') ? \Carbon\Carbon::parse(request('tgl'))->format('d F Y') : 'Semua Waktu' }}
            </td>
        </tr>
        <tr>
            <td colspan="5" class="text-center" style="font-size: 9pt; color: #64748b;">Dicetak pada: {{ date('d/m/Y H:i:s') }} WIB</td>
        </tr>
        <tr><td colspan="5"></td></tr> 
    </table>

    <table>
        <thead>
            <tr>
                <th class="bg-header border-all" width="5">NO</th>
                <th class="bg-header border-all" width="20">ID TRANSAKSI</th>
                <th class="bg-header border-all" width="25">TANGGAL & WAKTU</th>
                <th class="bg-header border-all" width="15">METODE</th>
                <th class="bg-header border-all" width="20">TOTAL AKHIR (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($data as $key => $d)
            @php $grandTotal += $d->total_akhir; @endphp
            <tr class="{{ $key % 2 == 0 ? '' : 'bg-zebra' }}">
                <td class="text-center border-all">{{ $key + 1 }}</td>
                <td class="text-center border-all text-format">#TRX-{{ str_pad($d->id_transaksi, 4, '0', STR_PAD_LEFT) }}</td>
                <td class="text-center border-all">{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y H:i') }}</td>
                <td class="text-center border-all">{{ strtoupper($d->metode) }}</td>
                <td class="text-right border-all currency" style="padding-right: 5px; font-weight: 500;">{{ $d->total_akhir }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right border-all bg-total" style="padding-right: 10px;">TOTAL PENDAPATAN</td>
                <td class="text-right border-all currency bg-total" style="padding-right: 5px;">{{ $grandTotal }}</td>
            </tr>
        </tfoot>
    </table>

    <table>
        <tr><td colspan="5"></td></tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="2" class="text-center" style="font-size: 9pt; color: #64748b; font-style: italic; height: 40px; vertical-align: bottom;">
                Dicetak secara otomatis oleh sistem Apotek Alfatih
            </td>
        </tr>
    </table>

</body>
</html>