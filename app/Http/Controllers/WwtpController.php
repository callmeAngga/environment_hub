<?php

namespace App\Http\Controllers;

use App\Models\WwtpDataHarian;
use App\Models\WwtpDataBulanan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WwtpDataHarianExport;
use App\Exports\WwtpDataBulananExport;

class WwtpController extends Controller
{
    public function index(Request $request)
    {
        $queryHarian = WwtpDataHarian::with(['wwtp', 'operator']);

        if ($request->filled('tanggal_dari') && $request->filled('tanggal_sampai')) {
            $queryHarian->whereBetween('tanggal', [$request->tanggal_dari, $request->tanggal_sampai]);
        }

        $sortHarian = $request->get('sort_harian', 'asc');
        $dataHarian = $queryHarian->orderBy('created_at', $sortHarian)->get();

        $queryBulanan = WwtpDataBulanan::with('wwtp', 'lab');

        if (
            $request->filled('bulan_dari') && $request->filled('tahun_dari') &&
            $request->filled('bulan_sampai') && $request->filled('tahun_sampai')
        ) {
            $queryBulanan->where(function ($q) use ($request) {
                $q->where(function ($subQ) use ($request) {
                    $subQ->where('tahun', '>', $request->tahun_dari)
                        ->orWhere(function ($dateQ) use ($request) {
                            $dateQ->where('tahun', $request->tahun_dari)
                                ->where('bulan', '>=', $request->bulan_dari);
                        });
                })->where(function ($subQ) use ($request) {
                    $subQ->where('tahun', '<', $request->tahun_sampai)
                        ->orWhere(function ($dateQ) use ($request) {
                            $dateQ->where('tahun', $request->tahun_sampai)
                                ->where('bulan', '<=', $request->bulan_sampai);
                        });
                });
            });
        }

        $sortBulanan = $request->get('sort_bulanan', 'asc');
        $dataBulanan = $queryBulanan->orderBy('created_at', $sortBulanan)->get();

        return view('pages.wwtp', compact('dataHarian', 'dataBulanan', 'sortHarian', 'sortBulanan'));
    }

    public function exportHarianExcel(Request $request)
    {
        $tanggalDari = $request->tanggal_dari;
        $tanggalSampai = $request->tanggal_sampai;

        $fileName = 'Data_WWTP_Harian_' . date('YmdHis') . '.xlsx';

        return Excel::download(
            new WwtpDataHarianExport($tanggalDari, $tanggalSampai),
            $fileName
        );
    }

    public function exportBulananExcel(Request $request)
    {
        $bulanDari = $request->bulan_dari;
        $tahunDari = $request->tahun_dari;
        $bulanSampai = $request->bulan_sampai;
        $tahunSampai = $request->tahun_sampai;

        $fileName = 'Data_WWTP_Bulanan_' . date('YmdHis') . '.xlsx';

        return Excel::download(
            new WwtpDataBulananExport($bulanDari, $tahunDari, $bulanSampai, $tahunSampai),
            $fileName
        );
    }

    public function storeHarian(Request $request)
    {
        $validated = $request->validate([
            'wwtp_id' => 'required|exists:lokasi_wwtp,id',
            'operator_id' => 'required|exists:operator_wwtp,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'debit_inlet' => 'nullable|numeric',
            'debit_outlet' => 'nullable|numeric',
            'ph_ekualisasi_1' => 'nullable|numeric|between:0,14',
            'ph_ekualisasi_2' => 'nullable|numeric|between:0,14',
            'suhu_ekualisasi_1' => 'nullable|numeric',
            'suhu_ekualisasi_2' => 'nullable|numeric',
            'ph_aerasi_1' => 'nullable|numeric|between:0,14',
            'ph_aerasi_2' => 'nullable|numeric|between:0,14',
            'sv30_aerasi_1' => 'nullable|integer',
            'sv30_aerasi_2' => 'nullable|integer',
            'do_aerasi_1' => 'nullable|numeric',
            'do_aerasi_2' => 'nullable|numeric',
            'ph_outlet' => 'nullable|numeric|between:0,14',
            'keterangan' => 'nullable|string'
        ]);

        try {
            WwtpDataHarian::create($validated);
            return redirect()->route('wwtp.index')->with('success', 'Data harian berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data harian: ' . $e->getMessage());
        }
    }

    public function updateHarian(Request $request, $id)
    {
        $validated = $request->validate([
            'wwtp_id' => 'required|exists:lokasi_wwtp,id',
            'operator_id' => 'required|exists:operator_wwtp,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'debit_inlet' => 'nullable|numeric',
            'debit_outlet' => 'nullable|numeric',
            'ph_ekualisasi_1' => 'nullable|numeric|between:0,14',
            'ph_ekualisasi_2' => 'nullable|numeric|between:0,14',
            'suhu_ekualisasi_1' => 'nullable|numeric',
            'suhu_ekualisasi_2' => 'nullable|numeric',
            'ph_aerasi_1' => 'nullable|numeric|between:0,14',
            'ph_aerasi_2' => 'nullable|numeric|between:0,14',
            'sv30_aerasi_1' => 'nullable|integer',
            'sv30_aerasi_2' => 'nullable|integer',
            'do_aerasi_1' => 'nullable|numeric',
            'do_aerasi_2' => 'nullable|numeric',
            'ph_outlet' => 'nullable|numeric|between:0,14',
            'keterangan' => 'nullable|string'
        ]);

        try {
            $data = WwtpDataHarian::findOrFail($id);
            $data->update($validated);
            return redirect()->route('wwtp.index')->with('success', 'Data harian berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data harian: ' . $e->getMessage());
        }
    }

    public function destroyHarian($id)
    {
        try {
            $data = WwtpDataHarian::findOrFail($id);
            $data->delete();
            return redirect()->route('wwtp.index')->with('success', 'Data harian berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data harian: ' . $e->getMessage());
        }
    }

    public function getDataHarian($id)
    {
        $data = WwtpDataHarian::findOrFail($id);
        return response()->json($data);
    }

    public function getDataBulanan($id)
    {
        $data = WwtpDataBulanan::findOrFail($id);
        return response()->json($data);
    }

    public function storeBulanan(Request $request)
    {
        $validated = $request->validate([
            'wwtp_id' => 'required|exists:lokasi_wwtp,id',
            'lab_id' => 'required|exists:lab,id',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'tss_inlet' => 'nullable|numeric',
            'tss_outlet' => 'nullable|numeric',
            'tds_inlet' => 'nullable|numeric',
            'tds_outlet' => 'nullable|numeric',
            'bod_inlet' => 'nullable|numeric',
            'bod_outlet' => 'nullable|numeric',
            'cod_inlet' => 'nullable|numeric',
            'cod_outlet' => 'nullable|numeric',
            'minyak_lemak_inlet' => 'nullable|numeric',
            'minyak_lemak_outlet' => 'nullable|numeric',
        ]);

        try {
            WwtpDataBulanan::create($validated);
            return redirect()->route('wwtp.index')->with('success', 'Data bulanan berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data bulanan: ' . $e->getMessage());
        }
    }

    public function updateBulanan(Request $request, $id)
    {
        $validated = $request->validate([
            'wwtp_id' => 'required|exists:lokasi_wwtp,id',
            'lab_id' => 'required|exists:lab,id',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'tss_inlet' => 'nullable|numeric',
            'tss_outlet' => 'nullable|numeric',
            'tds_inlet' => 'nullable|numeric',
            'tds_outlet' => 'nullable|numeric',
            'bod_inlet' => 'nullable|numeric',
            'bod_outlet' => 'nullable|numeric',
            'cod_inlet' => 'nullable|numeric',
            'cod_outlet' => 'nullable|numeric',
            'minyak_lemak_inlet' => 'nullable|numeric',
            'minyak_lemak_outlet' => 'nullable|numeric',
        ]);

        try {
            $data = WwtpDataBulanan::findOrFail($id);
            $data->update($validated);
            return redirect()->route('wwtp.index')->with('success', 'Data bulanan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data bulanan: ' . $e->getMessage());
        }
    }

    public function destroyBulanan($id)
    {
        try {
            $data = WwtpDataBulanan::findOrFail($id);
            $data->delete();
            return redirect()->route('wwtp.index')->with('success', 'Data bulanan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data bulanan: ' . $e->getMessage());
        }
    }
}
