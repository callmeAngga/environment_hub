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
    public function index(Request $request)
    {

        $wwtps = LokasiWwtp::latest()->get();
        $operators = OperatorWwtp::latest()->get();
        $labs = Lab::latest()->get();

       // === DATA PRODUKSI (Filter tipe = PRODUKSI) ===
        $tps_produksi = Tps::where('tipe', 'PRODUKSI')->latest()->get();
        $ekspedisi_produksi = DaftarEkspedisi::where('tipe', 'PRODUKSI')->latest()->get();
        $penerima_produksi = DaftarPenerima::where('tipe', 'PRODUKSI')->latest()->get();

        // === DATA DOMESTIK (Filter tipe = DOMESTIK) ===
        $tps_domestik = Tps::where('tipe', 'DOMESTIK')->latest()->get();
        $ekspedisi_domestik = DaftarEkspedisi::where('tipe', 'DOMESTIK')->latest()->get();
        $penerima_domestik = DaftarPenerima::where('tipe', 'DOMESTIK')->latest()->get();

        $satuan_sampah = SatuanSampah::latest()->get();
        $jenis_sampah = JenisSampah::latest()->get();

        $usersList = [];
        if (auth()->user()->role === 'ADMIN') {
            $query = \App\Models\User::where('role', '!=', 'ADMIN');

            if ($request->has('search_user') && $request->search_user != '') {
                $search = $request->search_user;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }
            $usersList = $query->latest()->get();
        }

        return view('pages.profile', compact(
            'wwtps',
            'usersList',
            'operators',
            'labs',

            'tps_produksi',
            'ekspedisi_produksi',
            'penerima_produksi',
            
            'tps_domestik',
            'ekspedisi_domestik',
            'penerima_domestik',

            'satuan_sampah',
            'jenis_sampah',
        ));
    }
}