<?php

namespace App\Http\Controllers;

use App\Models\WwtpDataHarian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard');
    }

    public function getChartData(Request $request)
    {
        $days = $request->input('days', 1);

        $startDate = Carbon::now()->subDays($days - 1)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // Ambil data dari database dengan relasi jika ada
        $data = WwtpDataHarian::whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc')
            ->get();

        $labels = [];
        $sv30_1 = [];
        $sv30_2 = [];
        $do_1 = [];
        $do_2 = [];

        foreach ($data as $item) {
            // Format label sesuai periode
            if ($days == 1) {
                // Untuk 1 hari: tampilkan jam saja
                $label = Carbon::parse($item->waktu)->format('H:i');
            } elseif ($days <= 7) {
                // Untuk 7 hari: tampilkan tanggal + jam
                $label = Carbon::parse($item->tanggal)->format('d/m') . ' ' . Carbon::parse($item->waktu)->format('H:i');
            } else {
                // Untuk 14-30 hari: tampilkan tanggal saja untuk menghemat ruang
                $label = Carbon::parse($item->tanggal)->format('d/m/y');
            }

            $labels[] = $label;

            // SV30 data - convert to float
            $sv30_1[] = floatval($item->sv30_aerasi_1 ?? 0);
            $sv30_2[] = floatval($item->sv30_aerasi_2 ?? 0);

            // DO data - convert to float
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
