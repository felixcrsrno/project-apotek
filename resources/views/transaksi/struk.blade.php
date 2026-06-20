<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $transaksi->id_transaksi }} | PharmaPOS</title>

    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f4f6f9;
            margin: 0;
            padding: 30px 20px;
            display: flex;
            justify-content: center;
            color: #000;
        }

        .struk-container {
            background-color: #fff;
            width: 310px;
            padding: 25px 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-radius: 4px;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }

        .logo {
            width: 85px;
            height: auto;
            margin-bottom: 12px;
        }

        .header h2 {
            margin: 0 0 4px 0;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header .system-title {
            font-size: 11px;
            font-weight: bold;
            color: #666;
            margin: 0 0 8px 0;
            letter-spacing: 2px;
        }

        .header .address {
            margin: 0;
            font-size: 11px;
            color: #444;
            line-height: 1.4;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 12px 0;
        }

        /* Info Transaksi Layout */
        .info-trx {
            font-size: 11px;
            line-height: 1.5;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
        }
        .info-label { width: 35%; }
        .info-value { width: 65%; text-align: left; }

        /* Item Table Layout */
        .item-list {
            width: 100%;
            font-size: 11px;
            border-collapse: collapse;
            margin-top: 5px;
        }
        .item-list th {
            border-bottom: 1px dashed #000;
            padding-bottom: 6px;
            font-weight: bold;
        }
        .item-row td {
            padding-top: 8px;
        }
        .item-calc td {
            padding-bottom: 8px;
            border-bottom: 1px dotted #ccc;
            color: #333;
        }

        /* Summary Section */
        .summary-table {
            width: 100%;
            font-size: 11px;
            border-collapse: collapse;
            margin-top: 5px;
        }
        .summary-table td {
            padding: 3px 0;
        }
        .summary-table .grand-total td {
            font-weight: bold;
            font-size: 13px;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 8px 0;
        }

        /* Buttons Area */
        .action-buttons {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }
        .btn {
            flex: 1;
            padding: 11px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            text-decoration: none;
            text-align: center;
            font-size: 13px;
            transition: all 0.2s;
        }
        .btn-print {
            background-color: #10b981;
            color: white;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
        }
        .btn-print:hover { background-color: #059669; }
        .btn-back {
            background-color: #e2e8f0;
            color: #1e293b;
        }
        .btn-back:hover { background-color: #cbd5e1; }

        @media print {
            body {
                background-color: #fff;
                padding: 0;
                align-items: flex-start;
            }
            .struk-container {
                box-shadow: none;
                width: 100%;
                max-width: 300px;
                padding: 0;
                margin: 0;
            }
            .action-buttons {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="struk-container">

        <div class="header text-center">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Apotek" class="logo">
            <h2>Apotek AlFatih</h2>
            <div class="system-title">PHARMAPOS</div>
            <p class="address">
                JL. Taman Makam Bahagia ABRI No.18<br>
                Perigi, Pondok Aren, Tangerang Selatan<br>
                Telp: (087)794019801
            </p>
        </div>

        <div class="divider"></div>

        <div class="info-trx">
            <div class="info-row">
                <span class="info-label">No. Struk</span>
                <span class="info-value">: #{{ str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal</span>
                <span class="info-value">: {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kasir</span>
                <span class="info-value">: {{ $transaksi->user->username ?? 'Kasir' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Metode</span>
                <span class="info-value">: {{ strtoupper($transaksi->metode ?? 'Tunai') }}</span>
            </div>
        </div>

        <div class="divider"></div>

        <table class="item-list">
            <thead>
                <tr>
                    <th align="left">Deskripsi Produk</th>
                    <th align="right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detail as $d)
                <tr class="item-row">
                    <td colspan="2" class="bold">{{ $d->obat->nama_obat }}</td>
                </tr>
                <tr class="item-calc">
                    <td>
                        &nbsp;&nbsp;{{ $d->jumlah }} x {{ number_format($d->subtotal / $d->jumlah, 0, ',', '.') }}
                    </td>
                    <td align="right">
                        {{ number_format($d->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="summary-table">
            @if(($transaksi->diskon ?? 0) > 0 || ($transaksi->ppn ?? 0) > 0)
            <tr>
                <td align="right" width="70%">Subtotal:</td>
                <td align="right">{{ number_format($detail->sum('subtotal'), 0, ',', '.') }}</td>
            </tr>
            @endif

            @if(($transaksi->diskon ?? 0) > 0)
            <tr>
                <td align="right">Diskon:</td>
                <td align="right">-{{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
            </tr>
            @endif

            @if(($transaksi->ppn ?? 0) > 0)
            <tr>
                <td align="right">PPN:</td>
                <td align="right">+{{ number_format($transaksi->ppn, 0, ',', '.') }}</td>
            </tr>
            @endif

            <tr class="grand-total">
                <td align="right">TOTAL AKHIR:</td>
                <td align="right">Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td align="right" style="padding-top: 6px;">Tunai/Bayar:</td>
                <td align="right" style="padding-top: 6px;">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td align="right">Kembalian:</td>
                <td align="right">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="text-center" style="font-size: 11px; line-height: 1.4;">
            <p class="bold">Terima Kasih Atas Kunjungan Anda</p>
            <p style="font-size: 10px; color: #333;">Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.<br>Semoga Lekas Sembuh.</p>
        </div>

        <div class="action-buttons">
            <a href="{{ url('/transaksi') }}" class="btn btn-back">Kembali</a>
            <button onclick="window.print()" class="btn btn-print">Cetak Struk</button>
        </div>

    </div>

    <script>
        window.onload = function () {
            window.print();
        }
    </script>

</body>
</html>