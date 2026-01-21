<?php

namespace App\Exports;

use App\Models\WwtpDataBulanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WwtpDataBulananExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $bulanDari;
    protected $tahunDari;
    protected $bulanSampai;
    protected $tahunSampai;

    public function __construct($bulanDari = null, $tahunDari = null, $bulanSampai = null, $tahunSampai = null)
    {
        $this->bulanDari = $bulanDari;
        $this->tahunDari = $tahunDari;
        $this->bulanSampai = $bulanSampai;
        $this->tahunSampai = $tahunSampai;
    }

    public function collection()
    {
        $query = WwtpDataBulanan::with('wwtp');

        if ($this->bulanDari && $this->tahunDari && $this->bulanSampai && $this->tahunSampai) {
            $query->where(function ($q) {
                $q->where(function ($subQ) {
                    $subQ->where('tahun', '>', $this->tahunDari)
                        ->orWhere(function ($dateQ) {
                            $dateQ->where('tahun', $this->tahunDari)
                                ->where('bulan', '>=', $this->bulanDari);
                        });
                })->where(function ($subQ) {
                    $subQ->where('tahun', '<', $this->tahunSampai)
                        ->orWhere(function ($dateQ) {
                            $dateQ->where('tahun', $this->tahunSampai)
                                ->where('bulan', '<=', $this->bulanSampai);
                        });
                });
            });
        }

        return $query->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Lokasi WWTP',
            'Bulan',
            'Tahun',
            'TSS Inlet',
            'TSS Outlet',
            'TDS Inlet',
            'TDS Outlet',
            'BOD Inlet',
            'BOD Outlet',
            'COD Inlet',
            'COD Outlet',
            'Minyak & Lemak Inlet',
            'Minyak & Lemak Outlet'
        ];
    }

    public function map($row): array
    {
        return [
            $row->wwtp->nama_wwtp ?? '-',
            $row->nama_bulan,
            $row->tahun,
            $row->tss_inlet ?? '-',
            $row->tss_outlet ?? '-',
            $row->tds_inlet ?? '-',
            $row->tds_outlet ?? '-',
            $row->bod_inlet ?? '-',
            $row->bod_outlet ?? '-',
            $row->cod_inlet ?? '-',
            $row->cod_outlet ?? '-',
            $row->minyak_lemak_inlet ?? '-',
            $row->minyak_lemak_outlet ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
