<?php

namespace App\Http\Controllers;

use App\Models\TpsDomestik;
use App\Models\Tps;
use App\Models\DaftarEkspedisi;
use App\Models\DaftarPenerima;
use App\Models\JenisSampah;
use App\Exports\TpsDomestikExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TpsDomestikController extends Controller
{
    public function index(Request $request)
    {
        $tpsList = Tps::orderBy('nama_tps')->get();
        $ekspedisiList = DaftarEkspedisi::orderBy('nama_ekspedisi')->get();
        $penerimaList = DaftarPenerima::orderBy('nama_penerima')->get();
        $jenisSampahList = JenisSampah::orderBy('nama_jenis')->get();

        $query = TpsDomestik::with(['tps', 'ekspedisi', 'penerima', 'jenisSampah']);

        if ($request->filled('tanggal_dari') && $request->filled('tanggal_sampai')) {
            $query->whereBetween('tanggal_pengangkutan', [$request->tanggal_dari, $request->tanggal_sampai]);
        }

        $dataDomestik = $query->latest('tanggal_pengangkutan')->paginate(15);

        return view('pages.tps-domestik', compact(
            'tpsList',
            'ekspedisiList',
            'penerimaList',
            'jenisSampahList',
            'dataDomestik'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tps_id' => 'required|exists:tps,id',
            'no_sampah_keluar' => 'required|string|max:50|unique:tps_domestik|regex:/^\d{10}$/',
            'tanggal_pengangkutan' => 'required|date',
            'ekspedisi_id' => 'required|exists:daftar_ekspedisi,id',
            'no_kendaraan' => 'required|string|max:20',
            'berat_bersih_kg' => 'required|numeric|min:0',
            'jenis_sampah_id' => 'required|exists:jenis_sampah,id',
            'penerima_id' => 'required|exists:daftar_penerima,id'
        ], [
            'tps_id.required' => 'TPS harus dipilih',
            'tps_id.exists' => 'TPS yang dipilih tidak valid',
            'no_sampah_keluar.required' => 'Nomor sampah keluar harus diisi',
            'no_sampah_keluar.unique' => 'Nomor sampah keluar sudah digunakan',
            'no_sampah_keluar.regex' => 'Format nomor sampah keluar harus YYYYMMXXXX (10 digit angka)',
            'tanggal_pengangkutan.required' => 'Tanggal pengangkutan harus diisi',
            'tanggal_pengangkutan.date' => 'Format tanggal tidak valid',
            'ekspedisi_id.required' => 'Ekspedisi harus dipilih',
            'ekspedisi_id.exists' => 'Ekspedisi yang dipilih tidak valid',
            'no_kendaraan.required' => 'Nomor kendaraan harus diisi',
            'no_kendaraan.max' => 'Nomor kendaraan maksimal 20 karakter',
            'berat_bersih_kg.required' => 'Berat bersih harus diisi',
            'berat_bersih_kg.numeric' => 'Berat bersih harus berupa angka',
            'berat_bersih_kg.min' => 'Berat bersih tidak boleh negatif',
            'jenis_sampah_id.required' => 'Jenis sampah harus dipilih',
            'jenis_sampah_id.exists' => 'Jenis sampah yang dipilih tidak valid',
            'penerima_id.required' => 'Penerima harus dipilih',
            'penerima_id.exists' => 'Penerima yang dipilih tidak valid'
        ]);

        try {
            TpsDomestik::create($validated);
            return redirect()->back()->with('success', 'Data TPS Domestik berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = TpsDomestik::with(['tps', 'ekspedisi', 'penerima', 'jenisSampah'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tps_id' => 'required|exists:tps,id',
            'no_sampah_keluar' => 'required|string|max:50|unique:tps_domestik,no_sampah_keluar,' . $id . '|regex:/^\d{10}$/',
            'tanggal_pengangkutan' => 'required|date',
            'ekspedisi_id' => 'required|exists:daftar_ekspedisi,id',
            'no_kendaraan' => 'required|string|max:20',
            'berat_bersih_kg' => 'required|numeric|min:0',
            'jenis_sampah_id' => 'required|exists:jenis_sampah,id',
            'penerima_id' => 'required|exists:daftar_penerima,id'
        ], [
            'tps_id.required' => 'TPS harus dipilih',
            'tps_id.exists' => 'TPS yang dipilih tidak valid',
            'no_sampah_keluar.required' => 'Nomor sampah keluar harus diisi',
            'no_sampah_keluar.unique' => 'Nomor sampah keluar sudah digunakan',
            'no_sampah_keluar.regex' => 'Format nomor sampah keluar harus YYYYMMXXXX (10 digit angka)',
            'tanggal_pengangkutan.required' => 'Tanggal pengangkutan harus diisi',
            'tanggal_pengangkutan.date' => 'Format tanggal tidak valid',
            'ekspedisi_id.required' => 'Ekspedisi harus dipilih',
            'ekspedisi_id.exists' => 'Ekspedisi yang dipilih tidak valid',
            'no_kendaraan.required' => 'Nomor kendaraan harus diisi',
            'no_kendaraan.max' => 'Nomor kendaraan maksimal 20 karakter',
            'berat_bersih_kg.required' => 'Berat bersih harus diisi',
            'berat_bersih_kg.numeric' => 'Berat bersih harus berupa angka',
            'berat_bersih_kg.min' => 'Berat bersih tidak boleh negatif',
            'jenis_sampah_id.required' => 'Jenis sampah harus dipilih',
            'jenis_sampah_id.exists' => 'Jenis sampah yang dipilih tidak valid',
            'penerima_id.required' => 'Penerima harus dipilih',
            'penerima_id.exists' => 'Penerima yang dipilih tidak valid'
        ]);

        try {
            $data = TpsDomestik::findOrFail($id);
            $data->update($validated);
            return redirect()->back()->with('success', 'Data TPS Domestik berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data = TpsDomestik::findOrFail($id);
            $data->delete();
            return redirect()->back()->with('success', 'Data TPS Domestik berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $tanggalDari = $request->tanggal_dari;
        $tanggalSampai = $request->tanggal_sampai;

        $fileName = 'Data_TPS_Domestik_' . date('YmdHis') . '.xlsx';

        return Excel::download(
            new TpsDomestikExport($tanggalDari, $tanggalSampai),
            $fileName
        );
    }
}