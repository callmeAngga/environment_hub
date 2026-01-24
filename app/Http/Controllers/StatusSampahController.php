<?php

namespace App\Http\Controllers;

use App\Models\StatusSampah;
use Illuminate\Http\Request;

class StatusSampahController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_status' => 'required|string|max:50|unique:status_sampah'
        ]);

        try {
            StatusSampah::create($validated);
            return redirect()->route('profile.index')->with('success', 'Status sampah berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_status' => 'required|string|max:50|unique:status_sampah,nama_status,' . $id
        ]);

        try {
            StatusSampah::findOrFail($id)->update($validated);
            return redirect()->route('profile.index')->with('success', 'Status sampah berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            StatusSampah::findOrFail($id)->delete();
            return redirect()->route('profile.index')->with('success', 'Status sampah berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}