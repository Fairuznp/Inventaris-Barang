<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Barang per Kategori</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
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
        .kategori-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .kategori-header {
            background-color: #f8f9fa;
            padding: 8px 12px;
            border: 1px solid #dee2e6;
            border-bottom: none;
            font-weight: bold;
            color: #495057;
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
            background-color: #e9ecef;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            color: #495057;
        }
        td {
            padding: 6px 8px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-primary { background-color: #007bff; color: white; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-warning { background-color: #ffc107; color: #212529; }
        .badge-danger { background-color: #dc3545; color: white; }
        .empty-message {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 20px;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN BARANG PER KATEGORI</h1>
        <p>Sistem Inventaris Barang</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    @foreach($kategoris as $kategori)
        <div class="kategori-section">
            <div class="kategori-header">
                📁 {{ $kategori->nama_kategori }} ({{ $kategori->barangs->count() }} barang)
            </div>
            
            @if($kategori->barangs->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th width="15%">Kode Barang</th>
                            <th width="35%">Nama Barang</th>
                            <th width="8%">Total</th>
                            <th width="8%">Baik</th>
                            <th width="10%">Rusak Ringan</th>
                            <th width="10%">Rusak Berat</th>
                            <th width="14%">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori->barangs as $barang)
                        <tr>
                            <td>{{ $barang->kode_barang }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td class="text-center">{{ $barang->jumlah_total }}</td>
                            <td class="text-center">{{ $barang->jumlah_baik }}</td>
                            <td class="text-center">{{ $barang->jumlah_rusak_ringan }}</td>
                            <td class="text-center">{{ $barang->jumlah_rusak_berat }}</td>
                            <td>{{ $barang->satuan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-message">
                    Belum ada barang di kategori ini
                </div>
            @endif
        </div>
    @endforeach

    <div class="footer">
        Dicetak pada {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>