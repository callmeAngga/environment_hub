<?php

namespace App\Http\Controllers;

use App\Models\LokasiWwtp;
use Illuminate\Http\Request;

class LokasiWwtpController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_wwtp' => 'required|string|max:255',
            'alamat' => 'required|string',
            'koordinat_lat' => 'required|numeric|between:-90,90',
            'koordinat_lng' => 'required|numeric|between:-180,180',
            'kapasitas_debit' => 'required|numeric|min:0'
        ]);

        try {
            LokasiWwtp::create($validated);
            return redirect()->route('profile.index')->with('success', 'Data WWTP berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_wwtp' => 'required|string|max:255',
            'alamat' => 'required|string',
            'koordinat_lat' => 'required|numeric|between:-90,90',
            'koordinat_lng' => 'required|numeric|between:-180,180',
            'kapasitas_debit' => 'required|numeric|min:0'
        ]);

        try {
            $wwtp = LokasiWwtp::findOrFail($id);
            $wwtp->update($validated);
            return redirect()->route('profile.index')->with('success', 'Data WWTP berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $wwtp = LokasiWwtp::findOrFail($id);
            $wwtp->delete();
            return redirect()->route('profile.index')->with('success', 'Data WWTP berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}