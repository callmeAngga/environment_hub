<?php

namespace App\Http\Controllers;

use App\Models\WwtpDataHarian;
use App\Models\LokasiWwtp;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $lokasiList = LokasiWwtp::orderBy('nama_wwtp', 'asc')->get();
        
        return view('pages.dashboard', compact('lokasiList'));
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
}