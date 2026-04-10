<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user dengan role 'admin'.
     */
    public function indexAdmin()
    {
        // Mengambil semua user yang memiliki role admin
        $users = User::where('role', 'admin')->latest()->get();
        $title = "Admin List";
        
        return view('admin.users.index', compact('users', 'title'));
    }

    /**
     * Menampilkan daftar user dengan role 'staff' (sebagai Operator).
     */
    public function indexOperator()
    {
        // Mengambil semua user yang memiliki role staff
        $users = User::where('role', 'staff')->latest()->get();
        $title = "Operator List";
        
        return view('admin.users.index', compact('users', 'title'));
    }

    /**
     * Menyimpan user baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,staff',
        ]);

        // Aturan password: 4 karakter awal email + nomor column (User::count + 1)
        $emailPrefix = substr($request->email, 0, 4);
        $userNumber = User::count() + 1;
        $password = $emailPrefix . $userNumber;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($password),
            'initial_password' => $password, // Simpan password plain untuk keperluan export
        ]);

        return back()->with('success', 'User berhasil ditambahkan! Password awal: ' . $password);
    }

    /**
     * Menghapus user.
     */
    public function destroy(User $user)
    {
        // Mencegah menghapus diri sendiri
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    /**
     * Memperbarui data user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:4',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Jika password diisi, enkripsi dan tambahkan ke data update
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
            $data['initial_password'] = null; // Set null jika password sudah diubah
        }

        $user->update($data);

        return back()->with('success', 'User ' . $user->name . ' berhasil diperbarui.');
    }

    /**
     * Meng-export data user ke Excel.
     */
    public function exportExcel(Request $request)
    {
        $role = $request->query('role'); // misal: admin atau staff
        $roleLabel = ($role == 'admin') ? 'admin-accounts' : (($role == 'staff') ? 'operator-accounts' : 'all-accounts');
        $filename = $roleLabel . '.xlsx';
        
        return Excel::download(new UsersExport($role), $filename);
    }

    /**
     * Reset password user (Operator) ke password default.
     */
    public function resetPassword(User $user)
    {
        // Reset password ke default (misal: 'operator123' atau password dinamis)
        $user->update([
            'password' => bcrypt('operator123')
        ]);

        return back()->with('success', 'Password user ' . $user->name . ' berhasil di-reset!');
    }
}
