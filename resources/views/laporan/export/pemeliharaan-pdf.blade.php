<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pemeliharaan Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .summary {
            margin-bottom: 25px;
        }
        .summary-row {
            display: flex;
            margin-bottom: 10px;
        }
        .summary-item {
            flex: 1;
            text-align: center;
            padding: 10px;
            border: 1px solid #dee2e6;
            margin-right: 10px;
        }
        .summary-item:last-child {
            margin-right: 0;
        }
        .summary-item h3 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }
        .summary-item p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th {
            background-color: #f8f9fa;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            color: #495057;
            font-size: 10px;
        }
        td {
            padding: 6px;
            font-size: 9px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge {
            display: inline-block;
            padding: 1px 4px;
            border-radius: 2px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-primary { background-color: #007bff; color: white; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-warning { background-color: #ffc107; color: #212529; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-info { background-color: #17a2b8; color: white; }
        .badge-dark { background-color: #343a40; color: white; }
        .empty-message {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 30px;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 9px;
            color: #6c757d;
        }
        .periode {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PEMELIHARAAN BARANG</h1>
        <p>Sistem Inventaris Barang</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="periode">
        <strong>Periode: {{ date('d/m/Y', strtotime($tanggal_mulai)) }} - {{ date('d/m/Y', strtotime($tanggal_selesai)) }}</strong>
    </div>

    <!-- Summary -->
    <div class="summary">
        <div class="summary-row">
            <div class="summary-item">
                <h3>{{ $summary['total_pemeliharaan'] }}</h3>
                <p>Total Pemeliharaan</p>
            </div>
            <div class="summary-item">
                <h3>{{ $summary['dalam_perbaikan'] }}</h3>
                <p>Dalam Perbaikan</p>
            </div>
            <div class="summary-item">
                <h3>{{ $summary['selesai'] }}</h3>
                <p>Selesai</p>
            </div>
            <div class="summary-item">
                <h3>Rp {{ number_format($summary['total_biaya'], 0, ',', '.') }}</h3>
                <p>Total Biaya</p>
            </div>
        </div>
    </div>

    @if($pemeliharaans->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="10%">Kode</th>
                    <th width="18%">Barang</th>
                    <th width="15%">Vendor</th>
                    <th width="12%">Jenis Kerusakan</th>
                    <th width="6%">Jumlah</th>
                    <th width="12%">Biaya</th>
                    <th width="8%">Tgl Kirim</th>
                    <th width="8%">Estimasi Selesai</th>
                    <th width="11%">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemeliharaans as $pemeliharaan)
                <tr>
                    <td>{{ $pemeliharaan->kode_pemeliharaan }}</td>
                    <td>
                        <strong>{{ $pemeliharaan->barang->nama_barang }}</strong><br>
                        <small>{{ $pemeliharaan->barang->kode_barang }}</small>
                    </td>
                    <td>
                        {{ $pemeliharaan->nama_vendor }}
                        @if($pemeliharaan->pic_vendor)
                            <br><small>PIC: {{ $pemeliharaan->pic_vendor }}</small>
                        @endif
                    </td>
                    <td>
                        {{ $pemeliharaan->jenis_kerusakan == 'rusak_ringan' ? 'Rusak Ringan' : 'Rusak Berat' }}
                        <br><small>{{ \Illuminate\Support\Str::limit($pemeliharaan->deskripsi_kerusakan, 30) }}</small>
                    </td>
                    <td class="text-center">{{ $pemeliharaan->jumlah_dipelihara }}</td>
                    <td class="text-right">
                        @if($pemeliharaan->biaya_aktual)
                            Rp {{ number_format($pemeliharaan->biaya_aktual, 0, ',', '.') }}
                        @elseif($pemeliharaan->estimasi_biaya)
                            Est: Rp {{ number_format($pemeliharaan->estimasi_biaya, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $pemeliharaan->tanggal_kirim->format('d/m/Y') }}</td>
                    <td>{{ $pemeliharaan->estimasi_selesai ? $pemeliharaan->estimasi_selesai->format('d/m/Y') : '-' }}</td>
                    <td>
                        @if($pemeliharaan->status == 'dikirim')
                            Dikirim
                        @elseif($pemeliharaan->status == 'dalam_perbaikan')
                            Dalam Perbaikan
                        @elseif($pemeliharaan->status == 'menunggu_approval')
                            Menunggu Approval
                        @elseif($pemeliharaan->status == 'selesai')
                            Selesai
                        @elseif($pemeliharaan->status == 'dibatalkan')
                            Dibatalkan
                        @elseif($pemeliharaan->status == 'tidak_bisa_diperbaiki')
                            Tidak Bisa Diperbaiki
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-message">
            Tidak ada data pemeliharaan pada periode yang dipilih
        </div>
    @endif

    <div class="footer">
        Dicetak pada {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>