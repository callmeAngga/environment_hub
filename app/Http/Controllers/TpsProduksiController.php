<?php

namespace App\Http\Controllers;

use App\Models\TpsProduksiMasuk;
use App\Models\TpsProduksiKeluar;
use App\Models\Tps;
use App\Models\SatuanSampah;
use App\Models\JenisSampah;
use App\Models\DaftarEkspedisi;
use App\Models\DaftarPenerima;
use App\Models\StatusSampah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TpsProduksiMasukExport;
use App\Exports\TpsProduksiKeluarExport;
use Barryvdh\DomPDF\Facade\Pdf;

class TpsProduksiController extends Controller
{
    public function index(Request $request)
    {
        $tpsList = Tps::where('tipe', 'PRODUKSI')->latest()->get();
        $satuanList = SatuanSampah::latest()->get();
        $jenisList = JenisSampah::latest()->get();
        $ekspedisiList = DaftarEkspedisi::where('tipe', 'PRODUKSI')->latest()->get();
        $penerimaList = DaftarPenerima::where('tipe', 'PRODUKSI')->latest()->get();
        $statusList = StatusSampah::latest()->get();

        $queryMasuk = TpsProduksiMasuk::with(['tps', 'satuanSampah', 'jenisSampah']);

        if ($request->filled('tanggal_masuk_dari') && $request->filled('tanggal_masuk_sampai')) {
            $queryMasuk->whereBetween('tanggal', [$request->tanggal_masuk_dari, $request->tanggal_masuk_sampai]);
        }

        $sortMasuk = $request->get('sort_masuk', 'asc');
        $dataMasuk = $queryMasuk->orderBy('created_at', $sortMasuk)->get();

        $queryKeluar = TpsProduksiKeluar::with(['tps', 'ekspedisi', 'jenisSampah', 'penerima', 'statusSampah']);

        if ($request->filled('tanggal_keluar_dari') && $request->filled('tanggal_keluar_sampai')) {
            $queryKeluar->whereBetween('tanggal_pengangkutan', [$request->tanggal_keluar_dari, $request->tanggal_keluar_sampai]);
        }

        $sortKeluar = $request->get('sort_keluar', 'asc');
        $dataKeluar = $queryKeluar->orderBy('created_at', $sortKeluar)->get();

        return view('pages.tps-produksi', compact(
            'tpsList',
            'satuanList',
            'jenisList',
            'ekspedisiList',
            'penerimaList',
            'statusList',
            'dataMasuk',
            'dataKeluar',
            'sortMasuk',
            'sortKeluar'
        ));
    }

    public function exportMasukExcel(Request $request)
    {
        $tanggalDari = $request->tanggal_masuk_dari;
        $tanggalSampai = $request->tanggal_masuk_sampai;

        $fileName = 'Data_TPS_Produksi_Masuk_' . date('YmdHis') . '.xlsx';

        return Excel::download(
            new TpsProduksiMasukExport($tanggalDari, $tanggalSampai),
            $fileName
        );
    }

    public function exportKeluarExcel(Request $request)
    {
        $tanggalDari = $request->tanggal_keluar_dari;
        $tanggalSampai = $request->tanggal_keluar_sampai;

        $fileName = 'Data_TPS_Produksi_Keluar_' . date('YmdHis') . '.xlsx';

        return Excel::download(
            new TpsProduksiKeluarExport($tanggalDari, $tanggalSampai),
            $fileName
        );
    }

    public function exportSinglePdf($id)
    {
        try {
            $data = TpsProduksiKeluar::with(['tps', 'ekspedisi', 'jenisSampah', 'penerima'])
                ->findOrFail($id);

            $pdf = PDF::loadView('pdf.surat-pengiriman-barang', compact('data'));
            $pdf->setPaper('a4', 'portrait');

            $filename = 'Surat_Pengiriman_' . $data->no_sampah_keluar . '_' . date('YmdHis') . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
    }

    public function getMasuk($id)
    {
        try {
            $data = TpsProduksiMasuk::findOrFail($id);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }

    public function getKeluar($id)
    {
        try {
            $data = TpsProduksiKeluar::findOrFail($id);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }

    public function storeMasuk(Request $request)
    {
        $validated = $request->validate([
            'tps_id' => 'required|exists:tps,id',
            'tanggal' => 'required|date',
            'jumlah_sampah' => 'required|integer|min:1',
            'satuan_sampah_id' => 'required|exists:satuan_sampah,id',
            'jenis_sampah_id' => 'required|exists:jenis_sampah,id'
        ], [
            'tps_id.required' => 'TPS harus dipilih',
            'tps_id.exists' => 'TPS tidak valid',
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'jumlah_sampah.required' => 'Jumlah sampah harus diisi',
            'jumlah_sampah.integer' => 'Jumlah sampah harus berupa angka',
            'jumlah_sampah.min' => 'Jumlah sampah minimal 1',
            'satuan_sampah_id.required' => 'Satuan sampah harus dipilih',
            'satuan_sampah_id.exists' => 'Satuan sampah tidak valid',
            'jenis_sampah_id.required' => 'Jenis sampah harus dipilih',
            'jenis_sampah_id.exists' => 'Jenis sampah tidak valid'
        ]);

        try {
            TpsProduksiMasuk::create($validated);
            return redirect()->back()->with('success', 'Data TPS Produksi Masuk berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function updateMasuk(Request $request, $id)
    {
        $validated = $request->validate([
            'tps_id' => 'required|exists:tps,id',
            'tanggal' => 'required|date',
            'jumlah_sampah' => 'required|integer|min:1',
            'satuan_sampah_id' => 'required|exists:satuan_sampah,id',
            'jenis_sampah_id' => 'required|exists:jenis_sampah,id'
        ]);

        try {
            $data = TpsProduksiMasuk::findOrFail($id);
            $data->update($validated);
            return redirect()->back()->with('success', 'Data TPS Produksi Masuk berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroyMasuk($id)
    {
        try {
            $data = TpsProduksiMasuk::findOrFail($id);
            $data->delete();
            return redirect()->back()->with('success', 'Data TPS Produksi Masuk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function storeKeluar(Request $request)
    {
        $validated = $request->validate([
            'tps_id' => 'required|exists:tps,id',
            'no_sampah_keluar' => 'required|string|max:50',
            'tanggal_pengangkutan' => 'required|date',
            'ekspedisi_id' => 'required|exists:daftar_ekspedisi,id',
            'no_kendaraan' => 'required|string|max:20',
            'berat_kosong_kg' => 'required|numeric|min:0',
            'berat_isi_kg' => 'required|numeric|min:0|gt:berat_kosong_kg',
            'jenis_sampah_id' => 'required|exists:jenis_sampah,id',
            'penerima_id' => 'required|exists:daftar_penerima,id',
            'total_unit' => 'required|integer',
            'status_sampah_id' => 'required|exists:status_sampah,id',
            'keterangan' => 'nullable|string',
        ], [
            'tps_id.required' => 'TPS harus dipilih',
            'no_sampah_keluar.required' => 'Nomor sampah keluar harus diisi',
            'tanggal_pengangkutan.required' => 'Tanggal pengangkutan harus diisi',
            'ekspedisi_id.required' => 'Ekspedisi harus dipilih',
            'no_kendaraan.required' => 'Nomor kendaraan harus diisi',
            'berat_kosong_kg.required' => 'Berat kosong harus diisi',
            'berat_kosong_kg.min' => 'Berat kosong tidak boleh negatif',
            'berat_isi_kg.required' => 'Berat isi harus diisi',
            'berat_isi_kg.min' => 'Berat isi tidak boleh negatif',
            'berat_isi_kg.gt' => 'Berat isi harus lebih besar dari berat kosong',
            'jenis_sampah_id.required' => 'Jenis sampah harus dipilih',
            'penerima_id.required' => 'Penerima harus dipilih',
            'total_unit.required' => 'Total unit harus diisi',
            'total_unit.integer' => 'Total unit harus berupa angka',
            'total_unit.min' => 'Total unit minimal 0',
            'status_sampah_id.required' => 'Status sampah harus dipilih'
        ]);

        try {
            TpsProduksiKeluar::create($validated);
            return redirect()->back()->with('success', 'Data TPS Produksi Keluar berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function updateKeluar(Request $request, $id)
    {
        $validated = $request->validate([
            'tps_id' => 'required|exists:tps,id',
            'no_sampah_keluar' => 'required|string|max:50',
            'tanggal_pengangkutan' => 'required|date',
            'ekspedisi_id' => 'required|exists:daftar_ekspedisi,id',
            'no_kendaraan' => 'required|string|max:20',
            'berat_kosong_kg' => 'required|numeric|min:0',
            'berat_isi_kg' => 'required|numeric|min:0|gt:berat_kosong_kg',
            'jenis_sampah_id' => 'required|exists:jenis_sampah,id',
            'penerima_id' => 'required|exists:daftar_penerima,id',
            'total_unit' => 'required|integer|min:0',
            'status_sampah_id' => 'required|exists:status_sampah,id',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $data = TpsProduksiKeluar::findOrFail($id);
            $data->update($validated);
            return redirect()->back()->with('success', 'Data TPS Produksi Keluar berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroyKeluar($id)
    {
        try {
            $data = TpsProduksiKeluar::findOrFail($id);
            $data->delete();
            return redirect()->back()->with('success', 'Data TPS Produksi Keluar berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
