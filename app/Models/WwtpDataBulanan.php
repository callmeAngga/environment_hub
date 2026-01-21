<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WwtpDataBulanan extends Model
{
    protected $table = 'wwtp_data_bulanan';

    protected $fillable = [
        'wwtp_id',
        'bulan',
        'tahun',
        'tss_inlet',
        'tss_outlet',
        'tds_inlet',
        'tds_outlet',
        'bod_inlet',
        'bod_outlet',
        'cod_inlet',
        'cod_outlet',
        'minyak_lemak_inlet',
        'minyak_lemak_outlet'
    ];

    protected $casts = [
        'tss_inlet' => 'decimal:2',
        'tss_outlet' => 'decimal:2',
        'tds_inlet' => 'decimal:2',
        'tds_outlet' => 'decimal:2',
        'bod_inlet' => 'decimal:2',
        'bod_outlet' => 'decimal:2',
        'cod_inlet' => 'decimal:2',
        'cod_outlet' => 'decimal:2',
        'minyak_lemak_inlet' => 'decimal:2',
        'minyak_lemak_outlet' => 'decimal:2'
    ];

    protected $appends = [
        'display_tss_inlet',
        'display_tss_outlet',
        'display_tds_inlet',
        'display_tds_outlet',
        'display_bod_inlet',
        'display_bod_outlet',
        'display_cod_inlet',
        'display_cod_outlet',
        'display_minyak_lemak_inlet',
        'display_minyak_lemak_outlet',
        'bulan_tahun',
        'nama_bulan'
    ];

    public function getDisplayTssInletAttribute()
    {
        return $this->formatDecimal($this->tss_inlet, 2);
    }

    public function getDisplayTssOutletAttribute()
    {
        return $this->formatDecimal($this->tss_outlet, 2);
    }

    public function getDisplayTdsInletAttribute()
    {
        return $this->formatDecimal($this->tds_inlet, 2);
    }

    public function getDisplayTdsOutletAttribute()
    {
        return $this->formatDecimal($this->tds_outlet, 2);
    }

    public function getDisplayBodInletAttribute()
    {
        return $this->formatDecimal($this->bod_inlet, 2);
    }

    public function getDisplayBodOutletAttribute()
    {
        return $this->formatDecimal($this->bod_outlet, 2);
    }

    public function getDisplayCodInletAttribute()
    {
        return $this->formatDecimal($this->cod_inlet, 2);
    }

    public function getDisplayCodOutletAttribute()
    {
        return $this->formatDecimal($this->cod_outlet, 2);
    }

    public function getDisplayMinyakLemakInletAttribute()
    {
        return $this->formatDecimal($this->minyak_lemak_inlet, 2);
    }

    public function getDisplayMinyakLemakOutletAttribute()
    {
        return $this->formatDecimal($this->minyak_lemak_outlet, 2);
    }

    public function getBulanTahunAttribute()
    {
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return $namaBulan[$this->bulan] . ' ' . $this->tahun;
    }

    public function getNamaBulanAttribute()
    {
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return $namaBulan[$this->bulan] ?? $this->bulan;
    }

    private function formatDecimal($value, $decimals = 2)
    {
        if (is_null($value)) {
            return '-';
        }

        $floatValue = floatval($value);
        $intValue = intval($value);

        $tolerance = 0.00001;
        if (abs($floatValue - $intValue) < $tolerance) {
            return (string)$intValue;
        }

        return number_format($floatValue, $decimals);
    }

    public function wwtp()
    {
        return $this->belongsTo(LokasiWwtp::class, 'wwtp_id');
    }
}
