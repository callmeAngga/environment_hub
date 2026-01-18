<?php

namespace App\Http\Controllers;

use App\Models\OperatorWwtp;
use Illuminate\Http\Request;

class OperatorWwtpController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate(['nama_operator' => 'required|string|max:255']);

        try {
            OperatorWwtp::create($validated);
            return redirect()->route('profile.index')->with('success', 'Operator berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate(['nama_operator' => 'required|string|max:255']);

        try {
            OperatorWwtp::findOrFail($id)->update($validated);
            return redirect()->route('profile.index')->with('success', 'Operator berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            OperatorWwtp::findOrFail($id)->delete();
            return redirect()->route('profile.index')->with('success', 'Operator berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}