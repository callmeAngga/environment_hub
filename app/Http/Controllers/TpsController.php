<?php

namespace App\Http\Controllers;

use App\Models\Tps;
use Illuminate\Http\Request;

class TpsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tps' => 'required|string|max:255',
            'alamat' => 'required|string',
            'koordinat_lat' => 'required|numeric|between:-90,90',
            'koordinat_lng' => 'required|numeric|between:-180,180',
            'kapasitas_max' => 'required|numeric|min:0'
        ]);

        try {
            Tps::create($validated);
            return redirect()->route('profile.index')->with('success', 'Data TPS berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_tps' => 'required|string|max:255',
            'alamat' => 'required|string',
            'koordinat_lat' => 'required|numeric|between:-90,90',
            'koordinat_lng' => 'required|numeric|between:-180,180',
            'kapasitas_max' => 'required|numeric|min:0'
        ]);

        try {
            Tps::findOrFail($id)->update($validated);
            return redirect()->route('profile.index')->with('success', 'Data TPS berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Tps::findOrFail($id)->delete();
            return redirect()->route('profile.index')->with('success', 'Data TPS berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}