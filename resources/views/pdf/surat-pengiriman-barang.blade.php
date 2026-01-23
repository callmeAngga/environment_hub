<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Pengiriman Barang</title>
    <style>
        @page {
            margin: 10mm 15mm;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.3;
            color: #000;
        }

        .bold { font-weight: bold; }
        .center { text-align: center; }
        .right { text-align: right; }
        .left { text-align: left; }
        .uppercase { text-transform: uppercase; }
        
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
        }
        .company-address {
            font-size: 9pt;
        }

        .recipient-box {
            margin-left: auto;
            width: 60%;
        }

        .info-label {
            display: inline-block;
            width: 100px;
        }
        .info-colon {
            display: inline-block;
            width: 10px;
            text-align: center;
        }

        .doc-title {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            margin: 20px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: middle;
        }
        .data-table th {
            text-align: center;
            font-weight: bold;
            height: 30px;
        }
        .data-table td {
            height: 40px;
        }

        .disclaimer {
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
            margin: 15px 0;
        }
        .doc-code-left {
            font-size: 9pt;
            position: absolute;
            left: 0;
        }
        .doc-code-right {
            font-size: 9pt;
            text-align: right;
        }

        .signature-table {
            width: 100%;
            margin-top: 20px;
            text-align: center;
        }
        .signature-space {
            height: 70px;
        }
        .signature-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .signature-role {
            margin-top: 5px;
        }

        .distribution-list {
            margin-top: 20px;
            font-size: 8pt;
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
            <td style="width: 55%">
                <div>Kepada Yth</div>
                <div class="bold">NON-BIWA</div> <div class="bold">{{ $data->penerima->nama_penerima ?? 'PT. Tenang Jaya Sejahtera' }}</div>
                <div>Waste Management Service</div>
            </td>

            <td style="width: 55%;padding-left: 148px;">
                <div>
                    <span class="info-label">SPB No</span>
                    <span class="info-colon">:</span>
                    <span>{{ $data->no_sampah_keluar }}</span>
                </div>
                <div>
                    <span class="info-label">Tanggal</span>
                    <span class="info-colon">:</span>
                    <span>{{ $data->tanggal_pengangkutan ? $data->tanggal_pengangkutan->format('d.m.Y') : '-' }}</span>
                </div>
            </td>
        </tr>
    </table>

    <br>

    <table class="layout-table">
        <tr>
            <td style="width: 55%;">
                <div>
                    <span class="info-label">Jasa ekspedisi</span>
                    <span class="info-colon">:</span>
                    <span>{{ $data->ekspedisi->nama_ekspedisi ?? '-' }}</span>
                </div>
                <div>
                    <span class="info-label">No Polisi</span>
                    <span class="info-colon">:</span>
                    <span>{{ $data->no_kendaraan }}</span>
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
                <td class="center">1</td>
                <td>{{ $data->jenisSampah->nama_jenis ?? '-' }}</td>
                <td class="center">Kilogram</td>
                <td class="center">{{ number_format($data->berat_isi_kg - $data->berat_kosong_kg, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <table class="layout-table">
        <tr>
            <td>
                <div class="bold">F.02.01/FGT-HR-004</div>
            </td>
        </tr>
    </table>

    <br>

    <div class="disclaimer">
        "KEKURANGAN BARANG SETELAH KELUAR DARI PABRIK MERUPAKAN TANGGUNG JAWAB EKSPEDISI"<br>
        "CLAIM KERUSAKAN/KEKURANGAN BARANG KEPADA EKSPEDISI"
    </div>

    <br>

    <table class="signature-table">
        <tr>
            <td style="width: 33%;">Dibuat Oleh</td>
            <td style="width: 33%;">Diketahui Oleh</td>
            <td style="width: 33%;">Diterima Oleh</td>
        </tr>
        <tr>
            <td class="signature-space"></td>
            <td class="signature-space"></td>
            <td class="signature-space"></td>
        </tr>
        <tr>
            <td>
                <span style="text-decoration: underline;">(________________)</span>
                <div>GAS Leader</div>
            </td>
            <td>
                <span style="text-decoration: underline;">(________________)</span>
                <div>GAS SPV</div>
            </td>
            <td>
                <span style="text-decoration: underline;">(________________)</span>
                <div>Ekspedisi</div>
            </td>
        </tr>
    </table>

    <div class="distribution-list">
        <div class="bold">Distribusi</div>
        <div>- Human Resource</div>
        <div>- Ekspedisi</div>
        <div>- Penerima Barang</div>
    </div>

</body>
</html>