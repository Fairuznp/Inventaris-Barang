<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman Barang</title>
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
        <h1>LAPORAN PEMINJAMAN BARANG</h1>
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
                <h3>{{ $summary['total_peminjaman'] }}</h3>
                <p>Total Peminjaman</p>
            </div>
            <div class="summary-item">
                <h3>{{ $summary['sedang_dipinjam'] }}</h3>
                <p>Sedang Dipinjam</p>
            </div>
            <div class="summary-item">
                <h3>{{ $summary['sudah_dikembalikan'] }}</h3>
                <p>Sudah Dikembalikan</p>
            </div>
            <div class="summary-item">
                <h3>{{ $summary['terlambat'] }}</h3>
                <p>Terlambat</p>
            </div>
        </div>
    </div>

    @if($peminjamans->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="8%">Tgl Pinjam</th>
                    <th width="20%">Barang</th>
                    <th width="15%">Peminjam</th>
                    <th width="15%">Instansi</th>
                    <th width="6%">Jumlah</th>
                    <th width="8%">Tgl Kembali</th>
                    <th width="8%">Tgl Aktual</th>
                    <th width="8%">Status</th>
                    <th width="12%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjamans as $peminjaman)
                <tr>
                    <td>{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $peminjaman->barang->nama_barang }}</strong><br>
                        <small>{{ $peminjaman->barang->kode_barang }}</small>
                    </td>
                    <td>
                        {{ $peminjaman->nama_peminjam }}
                        @if($peminjaman->kontak_peminjam)
                            <br><small>{{ $peminjaman->kontak_peminjam }}</small>
                        @endif
                    </td>
                    <td>{{ $peminjaman->instansi_peminjam ?? '-' }}</td>
                    <td class="text-center">{{ $peminjaman->jumlah }}</td>
                    <td>
                        {{ $peminjaman->tanggal_kembali ? $peminjaman->tanggal_kembali->format('d/m/Y') : '-' }}
                    </td>
                    <td>
                        {{ $peminjaman->tanggal_kembali_aktual ? $peminjaman->tanggal_kembali_aktual->format('d/m/Y') : '-' }}
                    </td>
                    <td>
                        @if($peminjaman->status == 'dipinjam')
                            Dipinjam
                        @elseif($peminjaman->status == 'dikembalikan')
                            Dikembalikan
                        @elseif($peminjaman->status == 'terlambat')
                            Terlambat
                        @elseif($peminjaman->status == 'hilang')
                            Hilang
                        @endif
                    </td>
                    <td>{{ \Illuminate\Support\Str::limit($peminjaman->keterangan ?? '-', 30) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-message">
            Tidak ada data peminjaman pada periode yang dipilih
        </div>
    @endif

    <div class="footer">
        Dicetak pada {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>