<?php

namespace App\Exports;

use App\Models\WwtpDataHarian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WwtpDataHarianExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
        $query = WwtpDataHarian::with(['wwtp', 'operator']);

        if ($this->tanggalDari && $this->tanggalSampai) {
            $query->whereBetween('tanggal', [$this->tanggalDari, $this->tanggalSampai]);
        }

        return $query->orderBy('tanggal', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Lokasi WWTP',
            'Tanggal',
            'Waktu',
            'Operator',
            'Debit Inlet (m³)',
            'Debit Outlet (m³)',
            'pH Ekualisasi 1',
            'pH Ekualisasi 2',
            'Suhu Ekualisasi 1 (°C)',
            'Suhu Ekualisasi 2 (°C)',
            'pH Aerasi 1',
            'pH Aerasi 2',  
            'SV30 Aerasi 1 (%)',
            'SV30 Aerasi 2 (%)',
            'DO Aerasi 1',
            'DO Aerasi 2',
            'pH Outlet',
            'Keterangan'
        ];
    }

    public function map($row): array
    {
        return [
            $row->wwtp->nama_wwtp ?? '-',
            $row->tanggal->format('d/m/Y'),
            substr($row->waktu, 0, 5),
            $row->operator->nama_operator ?? '-',
            $row->debit_inlet ?? '-',
            $row->debit_outlet ?? '-',
            $row->ph_ekualisasi_1 ?? '-',
            $row->ph_ekualisasi_2 ?? '-',
            $row->suhu_ekualisasi_1 ?? '-',
            $row->suhu_ekualisasi_2 ?? '-',
            $row->ph_aerasi_1 ?? '-',
            $row->ph_aerasi_2 ?? '-',
            $row->sv30_aerasi_1 ?? '-',
            $row->sv30_aerasi_2 ?? '-',
            $row->do_aerasi_1 ?? '-',
            $row->do_aerasi_2 ?? '-',
            $row->ph_outlet ?? '-',
            $row->keterangan ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
