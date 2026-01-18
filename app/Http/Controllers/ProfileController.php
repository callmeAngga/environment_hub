<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Panggil semua Model
use App\Models\LokasiWwtp;
use App\Models\OperatorWwtp;
use App\Models\Lab;
use App\Models\Tps;
use App\Models\SatuanSampah;
use App\Models\JenisSampah;
use App\Models\DaftarEkspedisi;
use App\Models\DaftarPenerima;

class ProfileController extends Controller
{
    public function index()
    {

        $wwtps = LokasiWwtp::latest()->get();
        $operators = OperatorWwtp::latest()->get();
        $labs = Lab::latest()->get();
        $tps = Tps::latest()->get();
        $satuan_sampah = SatuanSampah::latest()->get();
        $jenis_sampah = JenisSampah::latest()->get();
        $daftar_ekspedisi = DaftarEkspedisi::latest()->get();
        $daftar_penerima = DaftarPenerima::latest()->get();

        return view('pages.profile', compact(
            'wwtps',
            'operators',
            'labs',
            'tps',
            'satuan_sampah',
            'jenis_sampah',
            'daftar_ekspedisi',
            'daftar_penerima'
        ));
    }
}