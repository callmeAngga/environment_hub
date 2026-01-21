<?php

namespace App\Exports;

use App\Models\TpsDomestik;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TpsDomestikExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
        $query = TpsDomestik::with(['tps', 'ekspedisi', 'penerima', 'jenisSampah']);

        if ($this->tanggalDari && $this->tanggalSampai) {
            $query->whereBetween('tanggal_pengangkutan', [$this->tanggalDari, $this->tanggalSampai]);
        }

        return $query->orderBy('tanggal_pengangkutan', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Nama TPS',
            'No. Sampah Keluar',
            'Tanggal Pengangkutan',
            'Nama Ekspedisi',
            'No. Kendaraan',
            'Berat Bersih (kg)',
            'Jenis Sampah',
            'Nama Penerima'
        ];
    }

    public function map($row): array
    {
        return [
            $row->tps->nama_tps ?? '-',
            $row->no_sampah_keluar,
            $row->tanggal_pengangkutan->format('d/m/Y'),
            $row->ekspedisi->nama_ekspedisi ?? '-',
            $row->no_kendaraan,
            number_format($row->berat_bersih_kg, 2, ',', '.'),
            $row->jenisSampah->nama_jenis ?? '-',
            $row->penerima->nama_penerima ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
