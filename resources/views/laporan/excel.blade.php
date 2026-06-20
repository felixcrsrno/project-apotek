<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan PharmaPOS</title>
    <style>
        /* Styling Khusus untuk Excel */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
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
        .bg-light { 
            background-color: #f8fafc; 
        }
        .bg-total {
            background-color: #e2e8f0;
            font-weight: bold;
        }
        .border-all { 
            border: 1px solid #000000; 
        }
        /* Format angka Excel agar ribuan dipisah koma/titik tanpa desimal */
        /* stylelint-disable-next-line property-no-unknown */
        .currency { 
            mso-number-format:"\#\,\#\#0"; 
        } 
    </style>
</head>
<body>

    <table>
        <tr>
            <td colspan="5" class="header-title">LAPORAN PENJUALAN APOTEK ALFATIH</td>
        </tr>
        <tr>
            <td colspan="5" class="text-center">
                Periode: {{ request('tgl') ? \Carbon\Carbon::parse(request('tgl'))->format('d F Y') : 'Semua Waktu' }}
            </td>
        </tr>
        <tr>
            <td colspan="5" class="text-center">Dicetak pada: {{ date('d/m/Y H:i:s') }} WIB</td>
        </tr>
        <tr><td colspan="5"></td></tr> 
    </table>

    <table>
        <thead>
            <tr>
                <th class="bg-primary border-all" width="5">NO</th>
                <th class="bg-primary border-all" width="20">ID TRANSAKSI</th>
                <th class="bg-primary border-all" width="25">TANGGAL & WAKTU</th>
                <th class="bg-primary border-all" width="15">METODE</th>
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
                <td class="border-all text-center">{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y H:i') }}</td>
                <td class="text-center border-all">{{ strtoupper($d->metode) }}</td>
                <td class="text-right border-all currency" style="background-color: #f1f5f9;">{{ $d->total_akhir }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right border-all bg-total">TOTAL PENDAPATAN</td>
                <td class="text-right border-all currency bg-total">{{ $grandTotal }}</td>
            </tr>
        </tfoot>
    </table>

    <table>
        <tr><td colspan="5"></td></tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" class="text-center" style="font-size: 9pt; color: #64748b; font-style: italic;">
                Dicetak secara otomatis oleh sistem Apotek Alfatih
            </td>
        </tr>
    </table>

</body>
</html>