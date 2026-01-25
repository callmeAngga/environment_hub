<?php

namespace App\Exports;

use App\Models\TpsProduksiKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TpsProduksiKeluarExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $tanggalDari;
    protected $tanggalSampai;

    public function __construct($tanggalDari = null, $tanggalSampai = null)
    {
        $this->tanggalDari = $tanggalDari;
        $this->tanggalSampai = $tanggalSampai;
    }

    public function collection()
    {
        $query = TpsProduksiKeluar::with(['tps', 'ekspedisi', 'jenisSampah', 'penerima', 'statusSampah']);
        
        if ($this->tanggalDari && $this->tanggalSampai) {
            $query->whereBetween('tanggal_pengangkutan', [$this->tanggalDari, $this->tanggalSampai]);
        }
        
        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama TPS',
            'No. Sampah Keluar',
            'Tanggal Pengangkutan',
            'Ekspedisi',
            'No. Kendaraan',
            'Berat Kosong (kg)',
            'Berat Isi (kg)',
            'Berat Bersih (kg)',
            'Total Unit',
            'Status Sampah',
            'Jenis Sampah',
            'Penerima',
            'Keterangan',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        $beratBersih = $row->berat_isi_kg - $row->berat_kosong_kg;

        return [
            $no,
            $row->tps->nama_tps ?? '-',
            $row->no_sampah_keluar,
            $row->tanggal_pengangkutan ? $row->tanggal_pengangkutan->format('d/m/Y') : '-',
            $row->ekspedisi->nama_ekspedisi ?? '-',
            $row->no_kendaraan,
            number_format($row->berat_kosong_kg, 2, ',', '.'),
            number_format($row->berat_isi_kg, 2, ',', '.'),
            number_format($beratBersih, 2, ',', '.'),
            $row->total_unit,
            $row->statusSampah->nama_status ?? '-',
            $row->jenisSampah->nama_jenis ?? '-',
            $row->penerima->nama_penerima ?? '-',
            $row->keterangan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}