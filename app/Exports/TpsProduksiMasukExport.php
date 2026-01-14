<?php

namespace App\Exports;

use App\Models\TpsProduksiMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class TpsProduksiMasukExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
        $query = TpsProduksiMasuk::with(['tps', 'satuanSampah', 'jenisSampah']);

        if ($this->tanggalDari && $this->tanggalSampai) {
            $query->whereBetween('tanggal', [$this->tanggalDari, $this->tanggalSampai]);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama TPS',
            'Tanggal',
            'Jumlah Sampah',
            'Satuan',
            'Jenis Sampah',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->tps->nama_tps ?? '-',
            $row->tanggal ? $row->tanggal->format('d/m/Y') : '-',
            number_format($row->jumlah_sampah, 0, ',', '.'),
            $row->satuanSampah->nama_satuan ?? '-',
            $row->jenisSampah->nama_jenis ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}