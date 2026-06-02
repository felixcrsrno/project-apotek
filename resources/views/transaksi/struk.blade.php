<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $transaksi->id_transaksi }} | PharmaPOS</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; background-color: #f0f0f0; margin: 0; padding: 20px; display: flex; justify-content: center; }
        .struk-container { background-color: #fff; width: 300px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .text-center { text-align: center; } .text-right { text-align: right; }
        .header h3 { margin: 0 0 5px 0; font-size: 18px; }
        .header p { margin: 0; font-size: 12px; color: #555; }
        .divider { border-top: 1px dashed #000; margin: 10px 0; }
        .info-trx, .item-table, .summary-table { width: 100%; font-size: 12px; border-collapse: collapse; }
        .item-table th { border-bottom: 1px dashed #000; padding-bottom: 5px; text-align: left; }
        .total-row td { font-weight: bold; font-size: 14px; border-top: 1px dashed #000; padding-top: 5px; }
        .action-buttons { margin-top: 20px; display: flex; gap: 10px; }
        .btn { flex: 1; padding: 10px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-family: sans-serif; text-decoration: none; text-align: center; }
        .btn-print { background-color: #10b981; color: white; }
        .btn-back { background-color: #e2e8f0; color: #1e293b; }
        @media print { body { background-color: #fff; padding: 0; align-items: flex-start; } .struk-container { box-shadow: none; width: 100%; max-width: 300px; padding: 0; margin: 0 auto; } .action-buttons { display: none; } }
    </style>
</head>
<body>
    <div class="struk-container">
        <div class="header text-center">
            <h3>PHARMAPOS</h3>
            <p>Apotek Al-Fatih v2.0</p>
            <p>Jl. Kesehatan No. 123</p>
        </div>
        <div class="divider"></div>
        <div class="info-trx">
            <table width="100%">
                <tr><td>No. TRX</td><td>: #{{ str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT) }}</td></tr>
                <tr><td>Tanggal</td><td>: {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y H:i') }}</td></tr>
            </table>
        </div>
        <div class="divider"></div>
        <table class="item-table">
            <thead><tr><th>Item</th><th class="text-right">Total</th></tr></thead>
            <tbody>
                @foreach($detail as $d)
                <tr>
                    <td>{{ $d->obat->nama_obat }}<br>{{ $d->jumlah }} x {{ number_format($d->subtotal / $d->jumlah, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($d->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="divider"></div>
        <table class="summary-table">
            <tr class="total-row"><td>TOTAL</td><td class="text-right">Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</td></tr>
            <tr><td>Bayar</td><td class="text-right">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td></tr>
            <tr><td>Kembali</td><td class="text-right">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td></tr>
        </table>
        <div class="divider"></div>
        <div class="text-center" style="font-size: 11px; margin-top: 15px;"><p>Terima Kasih!<br>Semoga Lekas Sembuh</p></div>
        <div class="action-buttons">
            <a href="{{ url('/transaksi') }}" class="btn btn-back">Kembali</a>
            <button onclick="window.print()" class="btn btn-print">Cetak</button>
        </div>
    </div>
    <script>window.onload = function() { window.print(); }</script>
</body>
</html>