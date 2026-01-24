<?php

namespace App\Http\Controllers;

use App\Models\DaftarEkspedisi;
use Illuminate\Http\Request;

class DaftarEkspedisiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ekspedisi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tipe' => 'required|string|in:PRODUKSI,DOMESTIK'
        ]);

        try {
            DaftarEkspedisi::create($validated);
            return redirect()->route('profile.index')->with('success', 'Ekspedisi berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_ekspedisi' => 'required|string|max:255',
            'alamat' => 'required|string'
        ]);

        try {
            DaftarEkspedisi::findOrFail($id)->update($validated);
            return redirect()->route('profile.index')->with('success', 'Ekspedisi berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DaftarEkspedisi::findOrFail($id)->delete();
            return redirect()->route('profile.index')->with('success', 'Ekspedisi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}