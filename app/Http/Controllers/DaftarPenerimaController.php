<?php

namespace App\Http\Controllers;

use App\Models\DaftarPenerima;
use Illuminate\Http\Request;

class DaftarPenerimaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'alamat' => 'required|string'
        ]);

        try {
            DaftarPenerima::create($validated);
            return redirect()->route('profile.index')->with('success', 'Penerima berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'alamat' => 'required|string'
        ]);

        try {
            DaftarPenerima::findOrFail($id)->update($validated);
            return redirect()->route('profile.index')->with('success', 'Penerima berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DaftarPenerima::findOrFail($id)->delete();
            return redirect()->route('profile.index')->with('success', 'Penerima berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}