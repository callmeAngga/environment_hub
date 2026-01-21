<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WwtpDataHarian extends Model
{
    protected $table = 'wwtp_data_harian';

    protected $fillable = [
        'wwtp_id',
        'operator_id',
        'tanggal',
        'waktu',
        'debit_inlet',
        'debit_outlet',
        'ph_ekualisasi_1',
        'ph_ekualisasi_2',
        'suhu_ekualisasi_1',
        'suhu_ekualisasi_2',
        'ph_aerasi_1',
        'ph_aerasi_2',
        'sv30_aerasi_1',
        'sv30_aerasi_2',
        'do_aerasi_1',
        'do_aerasi_2',
        'ph_outlet',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'debit_inlet' => 'decimal:2',
        'debit_outlet' => 'decimal:2',
        'ph_ekualisasi_1' => 'decimal:1',
        'ph_ekualisasi_2' => 'decimal:1',
        'suhu_ekualisasi_1' => 'decimal:1',
        'suhu_ekualisasi_2' => 'decimal:1',
        'ph_aerasi_1' => 'decimal:1',
        'ph_aerasi_2' => 'decimal:1',
        'sv30_aerasi_1' => 'integer',
        'sv30_aerasi_2' => 'integer',
        'do_aerasi_1' => 'decimal:3',
        'do_aerasi_2' => 'decimal:3',
        'ph_outlet' => 'decimal:1'
    ];

    protected $appends = [
        'display_ph_ekualisasi_1',
        'display_ph_ekualisasi_2',
        'display_ph_aerasi_1',
        'display_ph_aerasi_2',
        'display_ph_outlet',
        'display_suhu_ekualisasi_1',
        'display_suhu_ekualisasi_2',
        'display_do_aerasi_1',
        'display_do_aerasi_2',
        'display_debit_inlet',
        'display_debit_outlet'
    ];

    public function getDisplayPhEkualisasi1Attribute()
    {
        return $this->formatDecimal($this->ph_ekualisasi_1, 1);
    }

    public function getDisplayPhEkualisasi2Attribute()
    {
        return $this->formatDecimal($this->ph_ekualisasi_2, 1);
    }

    public function getDisplayPhAerasi1Attribute()
    {
        return $this->formatDecimal($this->ph_aerasi_1, 1);
    }

    public function getDisplayPhAerasi2Attribute()
    {
        return $this->formatDecimal($this->ph_aerasi_2, 1);
    }

    public function getDisplayPhOutletAttribute()
    {
        return $this->formatDecimal($this->ph_outlet, 1);
    }

    public function getDisplaySuhuEkualisasi1Attribute()
    {
        $formatted = $this->formatDecimal($this->suhu_ekualisasi_1, 1);
        return $formatted === '-' ? '-' : $formatted . '°C';
    }

    public function getDisplaySuhuEkualisasi2Attribute()
    {
        $formatted = $this->formatDecimal($this->suhu_ekualisasi_2, 1);
        return $formatted === '-' ? '-' : $formatted . '°C';
    }

    public function getDisplayDoAerasi1Attribute()
    {
        return $this->formatDecimal($this->do_aerasi_1, 3);
    }

    public function getDisplayDoAerasi2Attribute()
    {
        return $this->formatDecimal($this->do_aerasi_2, 3);
    }

    public function getDisplayDebitInletAttribute()
    {
        $formatted = $this->formatDecimal($this->debit_inlet, 2);
        return $formatted === '-' ? '-' : $formatted . ' m³';
    }

    public function getDisplayDebitOutletAttribute()
    {
        $formatted = $this->formatDecimal($this->debit_outlet, 2);
        return $formatted === '-' ? '-' : $formatted . ' m³';
    }

    private function formatDecimal($value, $decimals = 1)
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

    public function operator()
    {
        return $this->belongsTo(OperatorWwtp::class, 'operator_id');
    }
}
