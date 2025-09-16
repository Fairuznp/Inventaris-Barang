<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang</title>
    @include('barang.partials.style-laporan')
</head>
<body>
    <div class="header">
        <h1>PT. INVENTORY BARANG</h1>
        <p>Jl. Raya Teknologi No. 123, Jakarta Selatan 12345</p>
        <p>Telp: (021) 12345678 | Email: info@inventorybarang.com</p>
        <hr>
    </div>

    <div class="title">
        <h2>LAPORAN DATA BARANG</h2>
        <p>Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>

    <div class="content">
        @include('barang.partials.list-laporan')
    </div>

    <div class="footer">
        <div class="signature">
            <div class="left">
                <p>Mengetahui,</p>
                <p class="position">Manager Inventory</p>
                <br><br><br>
                <p class="name">_______________________</p>
                <p>NIP: 198501152010031001</p>
            </div>
            <div class="right">
                <p>Jakarta, {{ date('d F Y') }}</p>
                <p class="position">Staff Inventory</p>
                <br><br><br>
                <p class="name">_______________________</p>
                <p>NIP: 199002202015032002</p>
            </div>
        </div>
    </div>
</body>
</html>