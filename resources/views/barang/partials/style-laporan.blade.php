<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        line-height: 1.4;
        color: #333;
        margin: 20px;
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
    }

    .header h1 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
        color: #2c3e50;
    }

    .header p {
        font-size: 11px;
        margin-bottom: 3px;
    }

    .header hr {
        border: none;
        border-top: 2px solid #2c3e50;
        margin-top: 10px;
    }

    .title {
        text-align: center;
        margin-bottom: 25px;
    }

    .title h2 {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 8px;
        color: #2c3e50;
        text-decoration: underline;
    }

    .title p {
        font-size: 11px;
        font-style: italic;
    }

    .content {
        margin-bottom: 40px;
    }

    .info-table {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    .info-table td {
        padding: 3px 8px;
        font-size: 11px;
        border: 1px solid #ddd;
    }

    .info-table .label {
        background-color: #f8f9fa;
        font-weight: bold;
        width: 150px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .data-table th,
    .data-table td {
        border: 1px solid #333;
        padding: 6px 4px;
        text-align: left;
        font-size: 10px;
    }

    .data-table th {
        background-color: #2c3e50;
        color: white;
        font-weight: bold;
        text-align: center;
    }

    .data-table td {
        vertical-align: top;
    }

    .data-table .text-center {
        text-align: center;
    }

    .data-table .text-right {
        text-align: right;
    }

    .data-table tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .summary {
        margin-top: 15px;
        padding: 10px;
        background-color: #e9ecef;
        border-radius: 5px;
    }

    .summary h4 {
        font-size: 12px;
        margin-bottom: 8px;
        color: #2c3e50;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        font-size: 11px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
    }

    .summary-item strong {
        color: #2c3e50;
    }

    .footer {
        margin-top: 50px;
    }

    .signature {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-top: 30px;
    }

    .signature .left,
    .signature .right {
        text-align: center;
        font-size: 11px;
    }

    .signature .position {
        font-weight: bold;
        margin-bottom: 40px;
    }

    .signature .name {
        font-weight: bold;
        border-bottom: 1px solid #333;
        display: inline-block;
        min-width: 150px;
        margin-bottom: 5px;
    }

    /* Print-specific styles */
    @media print {
        body {
            margin: 15px;
        }
        
        .header {
            margin-bottom: 20px;
        }
        
        .footer {
            page-break-inside: avoid;
        }
    }

    /* Responsive adjustments for smaller content */
    .data-table th:nth-child(1) { width: 8%; }   /* No */
    .data-table th:nth-child(2) { width: 12%; }  /* Kode */
    .data-table th:nth-child(3) { width: 20%; }  /* Nama */
    .data-table th:nth-child(4) { width: 15%; }  /* Kategori */
    .data-table th:nth-child(5) { width: 15%; }  /* Lokasi */
    .data-table th:nth-child(6) { width: 10%; }  /* Stok */
    .data-table th:nth-child(7) { width: 20%; }  /* Keterangan */
</style>