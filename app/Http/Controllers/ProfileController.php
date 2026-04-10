<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Menampilkan formulir edit profil untuk staff.
     */
    public function edit()
    {
        return view('staff.profile');
    }

    /**
     * Memperbarui profil staff yang sedang login.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:4',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Jika password diisi, enkripsi dan update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $data['initial_password'] = null; // Hapus catatan password awal jika sudah diubah
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }
}
