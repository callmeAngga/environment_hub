<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use Illuminate\Http\Request;

class JenisSampahController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jenis' => 'required|string|max:100|unique:jenis_sampah'
        ]);

        try {
            JenisSampah::create($validated);
            return redirect()->route('profile.index')->with('success', 'Jenis sampah berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_jenis' => 'required|string|max:100|unique:jenis_sampah,nama_jenis,' . $id
        ]);

        try {
            JenisSampah::findOrFail($id)->update($validated);
            return redirect()->route('profile.index')->with('success', 'Jenis sampah berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            JenisSampah::findOrFail($id)->delete();
            return redirect()->route('profile.index')->with('success', 'Jenis sampah berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}