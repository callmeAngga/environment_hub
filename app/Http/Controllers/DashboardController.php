<?php

namespace App\Http\Controllers;

use App\Models\WwtpDataHarian;
use App\Models\LokasiWwtp;
use App\Models\Tps;
use App\Models\TpsProduksiMasuk;
use App\Models\TpsProduksiKeluar;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $lokasiList = LokasiWwtp::orderBy('nama_wwtp', 'asc')->get();
        $tpsList = Tps::where('tipe', 'Produksi')
            ->orderBy('nama_tps', 'asc')
            ->get();
        
        return view('pages.dashboard', compact('lokasiList', 'tpsList'));
    }

    public function getChartData(Request $request)
    {
        $days = $request->input('days', 1);
        $lokasiId = $request->input('lokasi_id', null);

        $startDate = Carbon::now()->subDays($days - 1)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $query = WwtpDataHarian::whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc');

        if ($lokasiId) {
            $query->where('wwtp_id', $lokasiId);
        }

        $data = $query->get();

        $labels = [];
        $sv30_1 = [];
        $sv30_2 = [];
        $do_1 = [];
        $do_2 = [];

        foreach ($data as $item) {
            if ($days == 1) {
                $label = Carbon::parse($item->waktu)->format('H:i');
            } elseif ($days <= 7) {
                $label = Carbon::parse($item->tanggal)->format('d/m') . ' ' . Carbon::parse($item->waktu)->format('H:i');
            } else {
                $label = Carbon::parse($item->tanggal)->format('d/m/y');
            }

            $labels[] = $label;

            $sv30_1[] = floatval($item->sv30_aerasi_1 ?? 0);
            $sv30_2[] = floatval($item->sv30_aerasi_2 ?? 0);

            $do_1[] = floatval($item->do_aerasi_1 ?? 0);
            $do_2[] = floatval($item->do_aerasi_2 ?? 0);
        }

        return response()->json([
            'labels' => $labels,
            'sv30' => [
                'aerasi_1' => $sv30_1,
                'aerasi_2' => $sv30_2
            ],
            'do' => [
                'aerasi_1' => $do_1,
                'aerasi_2' => $do_2
            ]
        ]);
    }

    public function getChartStokSampah(Request $request)
    {
        $days = $request->input('days', 7);
        $tpsId = $request->input('tps_id', null);

        $startDate = Carbon::now()->subDays($days - 1)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // Hitung stok awal (sebelum periode filter)
        $stokAwalQuery = DB::table('tps_produksi_masuk')
            ->select(DB::raw('COALESCE(SUM(jumlah_sampah), 0) as total_masuk'))
            ->where('tanggal', '<', $startDate);

        $stokKeluarQuery = DB::table('tps_produksi_keluar')
            ->select(DB::raw('COALESCE(SUM(total_unit), 0) as total_keluar'))
            ->where('tanggal_pengangkutan', '<', $startDate);

        if ($tpsId) {
            $stokAwalQuery->where('tps_id', $tpsId);
            $stokKeluarQuery->where('tps_id', $tpsId);
        }

        $totalMasukSebelumnya = $stokAwalQuery->value('total_masuk') ?? 0;
        $totalKeluarSebelumnya = $stokKeluarQuery->value('total_keluar') ?? 0;
        $stokAwal = $totalMasukSebelumnya - $totalKeluarSebelumnya;

        // Ambil data masuk per tanggal
        $dataMasukQuery = TpsProduksiMasuk::select(
                DB::raw('DATE(tanggal) as tanggal'),
                DB::raw('SUM(jumlah_sampah) as total')
            )
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(tanggal)'));

        if ($tpsId) {
            $dataMasukQuery->where('tps_id', $tpsId);
        }

        $dataMasuk = $dataMasukQuery->pluck('total', 'tanggal')->toArray();

        // Ambil data keluar per tanggal
        $dataKeluarQuery = TpsProduksiKeluar::select(
                DB::raw('DATE(tanggal_pengangkutan) as tanggal'),
                DB::raw('SUM(total_unit) as total')
            )
            ->whereBetween('tanggal_pengangkutan', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(tanggal_pengangkutan)'));

        if ($tpsId) {
            $dataKeluarQuery->where('tps_id', $tpsId);
        }

        $dataKeluar = $dataKeluarQuery->pluck('total', 'tanggal')->toArray();

        // Generate semua tanggal dalam range
        $labels = [];
        $stokData = [];
        $masukData = [];
        $keluarData = [];
        
        $currentStok = $stokAwal;
        $currentDate = Carbon::parse($startDate);

        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            
            // Format label berdasarkan periode
            if ($days <= 7) {
                $label = $currentDate->format('d/m');
            } else {
                $label = $currentDate->format('d/m/y');
            }
            
            $masuk = $dataMasuk[$dateStr] ?? 0;
            $keluar = $dataKeluar[$dateStr] ?? 0;
            
            $currentStok = $currentStok + $masuk - $keluar;
            
            $labels[] = $label;
            $stokData[] = $currentStok;
            $masukData[] = $masuk;
            $keluarData[] = $keluar;
            
            $currentDate->addDay();
        }

        return response()->json([
            'labels' => $labels,
            'stok' => $stokData,
            'masuk' => $masukData,
            'keluar' => $keluarData,
            'stok_awal' => $stokAwal
        ]);
    }
}