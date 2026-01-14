<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Pengiriman Barang</title>
    <style>
        @page {
            margin: 20mm;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .company-name {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .company-info {
            font-size: 9pt;
            margin-bottom: 2px;
        }
        
        .document-title {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        
        .info-section {
            margin-bottom: 20px;
        }
        
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 3px;
        }
        
        .info-label {
            display: table-cell;
            width: 100px;
            font-size: 10pt;
        }
        
        .info-colon {
            display: table-cell;
            width: 15px;
        }
        
        .info-value {
            display: table-cell;
            font-size: 10pt;
        }
        
        .address-section {
            margin-bottom: 20px;
        }
        
        .address-row {
            margin-bottom: 3px;
        }
        
        .address-label {
            font-size: 10pt;
            display: inline-block;
            width: 120px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        table th {
            background-color: #f5f5f5;
            border: 1px solid #000;
            padding: 10px 8px;
            font-size: 10pt;
            font-weight: bold;
            text-align: center;
        }
        
        table td {
            border: 1px solid #000;
            padding: 50px 8px;
            font-size: 10pt;
        }
        
        table td.center {
            text-align: center;
        }
        
        table td.right {
            text-align: right;
        }
        
        .footer-note {
            font-size: 8pt;
            font-style: italic;
            text-align: right;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        
        .disclaimer {
            font-size: 8pt;
            font-style: italic;
            margin: 15px 0;
            text-align: center;
        }
        
        .signature-section {
            margin-top: 40px;
        }
        
        .signature-row {
            display: table;
            width: 100%;
        }
        
        .signature-cell {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            vertical-align: top;
        }
        
        .signature-label {
            font-size: 10pt;
            margin-bottom: 5px;
        }
        
        .signature-space {
            height: 60px;
        }
        
        .signature-name {
            font-size: 10pt;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 5px;
        }
        
        .signature-position {
            font-size: 9pt;
            font-style: italic;
        }
        
        .biwa-section {
            margin-top: 20px;
            text-align: right;
        }
        
        .biwa-label {
            font-size: 10pt;
            display: inline-block;
            width: 150px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">PT INDOFOOD CBP SUKSES MAKMUR Tbk</div>
        <div class="company-info">Jalan Raya Pamanukan – Cilacap KM 15, Desa Cilacap</div>
        <div class="company-info">Kecamatan Pamanukan, Subang – Purwakarta, Jawa Barat</div>
        <div class="company-info">Telp/Fax: (0260) 540004</div>
    </div>
    
    <div style="float: right; text-align: left; margin-bottom: 15px;">
        <div style="font-size: 10pt; margin-bottom: 3px;">
            <span style="display: inline-block; width: 70px;">SPB No</span>
            <span>: {{ $data->no_sampah_keluar }}</span>
        </div>
        <div style="font-size: 10pt;">
            <span style="display: inline-block; width: 70px;">Tanggal</span>
            <span>: {{ $data->tanggal_pengangkutan ? $data->tanggal_pengangkutan->format('d.m.Y') : '-' }}</span>
        </div>
    </div>
    
    <div style="clear: both;"></div>
    
    <div class="info-section">
        <div style="font-size: 10pt; margin-bottom: 8px;">
            <strong>NON-BIWA</strong>
        </div>
        <div style="font-size: 10pt; margin-bottom: 3px;">
            PT Tenang Jaya Sejahtera
        </div>
        <div style="font-size: 10pt;">
            Waste Management Service
        </div>
    </div>
    
    <div class="address-section">
        <div class="address-row">
            <span class="address-label">Akan diantar di</span>
            <span style="font-size: 10pt;">: {{ $data->penerima->nama_penerima ?? '-' }}</span>
        </div>
        <div class="address-row">
            <span class="address-label">No Polisi</span>
            <span style="font-size: 10pt;">: {{ $data->no_kendaraan }}</span>
        </div>
    </div>
    
    <div class="document-title">SURAT PENGIRIMAN BARANG</div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 45%;">NAMA BARANG</th>
                <th style="width: 15%;">SATUAN</th>
                <th style="width: 20%;">JUMLAH/<br/>SATUAN</th>
                <th style="width: 15%;">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="center">1</td>
                <td>{{ $data->jenisSampah->nama_jenis ?? '-' }}</td>
                <td class="center">Kilogram</td>
                <td class="right" style="padding-right: 15px;">{{ number_format($data->berat_isi_kg - $data->berat_kosong_kg, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    
    <div class="footer-note">
        F.02.00/FGT/NR-004
    </div>
    
    <div class="disclaimer">
        ***KETERANGAN BARANG SETELAH KELUAR DARI PABRIK MERUPAKAN TANGGUNG JAWAB EXPEDISI***<br/>
        ***DAN KEPERCAYAAN/KEKELUARGAAN BARANG KEPADA EXPEDISI***
    </div>
    
    <div class="signature-section">
        <div class="signature-row">
            <div class="signature-cell">
                <div class="signature-label">Dibuat Oleh</div>
                <div class="signature-space"></div>
                <div class="signature-name">________________</div>
            </div>
            <div class="signature-cell">
                <div class="signature-label">Diketahui Oleh</div>
                <div class="signature-space"></div>
                <div class="signature-name">________________</div>
            </div>
            <div class="signature-cell">
                <div class="signature-label">Diterima Oleh</div>
                <div class="signature-space"></div>
                <div class="signature-name">________________</div>
            </div>
        </div>
        <div class="signature-row" style="margin-top: 5px;">
            <div class="signature-cell">
                <div class="signature-label">GA2 Loader</div>
            </div>
            <div class="signature-cell">
                <div class="signature-label">GA2 SPV</div>
            </div>
            <div class="signature-cell">
                <div class="signature-label">Ekspedisi</div>
            </div>
        </div>
        <div class="signature-row" style="margin-top: 15px; font-size: 9pt; font-style: italic;">
            <div class="signature-cell">
                <div>Sharia Heryanto</div>
            </div>
            <div class="signature-cell">
                <div>Sharia Hai</div>
            </div>
            <div class="signature-cell">
                <div>Penerima Barang</div>
            </div>
        </div>
    </div>
    
    <div class="biwa-section">
        <div style="font-size: 10pt; margin-top: 25px;">
            <span class="biwa-label">BIWA (KG)</span>
            <span>: ________________</span>
        </div>
    </div>
</body>
</html>