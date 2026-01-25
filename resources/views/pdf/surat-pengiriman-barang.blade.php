<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Pengiriman Barang</title>
    <style>
        @page {
            margin: 20mm 30mm;
        }
        
        body {
            font-family: 'Book Antiqua', serif;
            font-size: 10pt;
            line-height: 1.3;
            color: #000;
        }

        .bold { font-weight: bold; }
        .center { text-align: center; }
        .right { text-align: right; }
        
        .layout-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .layout-table td {
            border: none;
            vertical-align: top;
            padding: 0;
        }

        .company-name {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .company-address {
            line-height: 1.2;
        }

        .info-row { 
            margin-bottom: 2px;
            display: flex;
            align-items: center;
        }
        .info-label { 
            display: inline-block; 
            width: 100px;
        }
        .info-label-mini { 
            display: inline-block; 
            width: 55px;
        }
        .info-colon { 
            display: inline-block; 
            width: 10px; 
            text-align: center;
        }
        .info-value {
            display: inline-block;
        }

        .doc-title {
            font-size: 18pt;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 15px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 5px 8px;
            vertical-align: top;
        }
        .data-table th {
            text-align: center;
            font-weight: bold;
            background-color: #fff;
            height: 25px;
        }
        .data-table td {
            height: 40px; 
        }
        .footer-code {
            text-align: right;
            font-size: 9pt;
            margin-bottom: 10px;
            padding-right: 42px;
        }

        .disclaimer {
            text-align: left;
            font-size: 8pt;
            font-style: italic;
            font-weight: bold;
            margin: 15px 0;
            line-height: 1.4;
        }

        .signature-table {
            width: 100%;
            margin-top: 20px;
            text-align: center;
        }
        .signature-space {
            height: 70px;
        }
        .signature-role {
            margin-top: 3px;
            font-size: 10pt;
        }

        .distribution-list {
            line-height: 1.3;
        }
        .distribution-list div {
            margin-bottom: 2px;
        }
    </style>
</head>
<body>

    <table class="layout-table">
        <tr>
            <td style="width: 55%;">
                <div class="company-name">PT INDOFOOD CBP SUKSES MAKMUR Tbk</div>
                <div class="company-address">
                    Jalan Raya Purwakarta - Cikopo KM 13, Desa Cikopo<br>
                    Kecamatan Bungursari Kabupaten Purwakarta, Jawa Barat<br>
                    Telp (0264) 313 511 Fax (0264) 313 505
                </div>
            </td>
        </tr>
    </table>

    <br>

    <table class="layout-table">
        <tr> 
            <td style="width: 72%;">
                <div>Kepada Yth</div>
                <div style="margin: 2px 0;">{{ $data->penerima->nama_penerima ?? 'PT. Tenang Jaya Sejahtera' }}</div>
                <div >Waste Management Service</div>
                <div style=" width: 95%; line-height: 1.2; margin-top: 2px;">
                    {{ $data->penerima->alamat ?? '-' }}
                </div>
            </td>
            
            <td style="width: 28%;">
                <div class="info-row">
                    <span class="info-label-mini">SPB No</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $data->no_sampah_keluar }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label-mini">Tanggal</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $data->tanggal_pengangkutan ? $data->tanggal_pengangkutan->format('d.m.Y') : '-' }}</span>
                </div>
            </td>
        </tr>
    </table>

    <br>

    <table>
        <tr>
            <td style="width: 55%;">
                <div class="info-row">
                    <span class="info-label">Jasa ekspedisi</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $data->ekspedisi->nama_ekspedisi ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">No Polisi</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $data->no_kendaraan }}</span>
                </div>
            </td>
        </tr>
    </table>

    <div class="doc-title">SURAT PENGIRIMAN BARANG</div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 35%;">NAMA BARANG</th>
                <th style="width: 15%;">SATUAN</th>
                <th style="width: 15%;">JUMLAH<br>SATUAN</th>
                <th style="width: 30%;">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="center" style="height: 300px; font-style: italic;">1</td>
                <td style="height: 300px;">{{ $data->jenisSampah->nama_jenis ?? '-' }}</td>
                <td class="center" style="height: 300px; font-style: italic;">Kilogram</td>
                <td class="center" style="height: 300px;">{{ number_format($data->berat_isi_kg - $data->berat_kosong_kg, 0, ',', '.') }}</td>
                <td style="height: 300px;">{{ $data->keterangan ?? '' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer-code">F.02.02/FGT-HR-004</div>

    <div class="disclaimer">
        "KEKURANGAN BARANG SETELAH KELUAR DARI PABRIK MERUPAKAN TANGGUNG JAWAB EKSPEDISI"<br>
        "CLAIM KERUSAKAN/KEKURANGAN BARANG KEPADA EKSPEDISI"
    </div>

    <table class="layout-table" style="margin-top: 30px;">
        <tr>
            <td style="width: 30%; vertical-align: top;">
                <div class="distribution-list">
                    <div style="margin-bottom: 5px;">Distribusi</div>
                    <div>- Human Resource</div>
                    <div>- Ekspedisi</div>
                    <div>- Penerima Barang</div>
                </div>
            </td>

            <td style="width: 40%; text-align: center; vertical-align: top;">
                <div>Disetujui Oleh</div>
                <div style="height: 60px;"></div>
                
                <div class="signature-name">(________________)</div>
                <div style="margin-top: 5px;">________________</div>
            </td>

            <td style="width: 30%; text-align: center; vertical-align: top;">
                <div>Diterima Oleh</div>
                <div style="height: 60px;"></div>
                
                <div class="signature-name">(________________)</div>
                <div class="signature-role">Ekspedisi</div>
            </td>
        </tr>
    </table>

</body>
</html>