<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        // Auto generate nama dari email (karena form cuma minta email & password)
        // Contoh: budi@gmail.com -> Namanya jadi "budi"
        $name = explode('@', $request->email)[0];

        User::create([
            'name' => ucfirst($name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'USER'
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,'.$id,
            // Password nullable, kalau kosong berarti gak diganti
            'password' => 'nullable|min:6'
        ]);

        $data = [
            'email' => $request->email,
        ];

        // Cek apakah password diisi?
        if($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Cegah Admin menghapus dirinya sendiri
        if(auth()->user()->id == $id) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        User::destroy($id);
        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
