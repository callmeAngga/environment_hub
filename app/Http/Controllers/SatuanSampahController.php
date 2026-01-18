<?php

namespace App\Http\Controllers;

use App\Models\SatuanSampah;
use Illuminate\Http\Request;

class SatuanSampahController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_satuan' => 'required|string|max:50|unique:satuan_sampah'
        ]);

        try {
            SatuanSampah::create($validated);
            return redirect()->route('profile.index')->with('success', 'Satuan sampah berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_satuan' => 'required|string|max:50|unique:satuan_sampah,nama_satuan,' . $id
        ]);

        try {
            SatuanSampah::findOrFail($id)->update($validated);
            return redirect()->route('profile.index')->with('success', 'Satuan sampah berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            SatuanSampah::findOrFail($id)->delete();
            return redirect()->route('profile.index')->with('success', 'Satuan sampah berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}