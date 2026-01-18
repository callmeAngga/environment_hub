<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lab' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255'
        ]);

        try {
            Lab::create($validated);
            return redirect()->route('profile.index')->with('success', 'Lab berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_lab' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255'
        ]);

        try {
            Lab::findOrFail($id)->update($validated);
            return redirect()->route('profile.index')->with('success', 'Lab berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Lab::findOrFail($id)->delete();
            return redirect()->route('profile.index')->with('success', 'Lab berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}