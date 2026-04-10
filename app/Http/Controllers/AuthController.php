<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Menampilkan halaman form login
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Melakukan validasi input dari user
        // Memastikan email dan password diisi sesuai dengan format yang benar, dan pesannya dalam bahasa Indonesia
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email tidak boleh kosong (wajib diisi).',
            'email.email' => 'Format email yang Anda masukkan tidak valid.',
            'password.required' => 'Password tidak boleh kosong (wajib diisi).',
        ]);

        // 2. Mengecek apakah checkbox "Remember Me" dicentang
        $remember = $request->boolean('remember');

        // Mencoba melakukan proses autentikasi
        // Auth::attempt akan mengecek email dan password cocok atau tidak dengan data di database
        if (Auth::attempt($credentials, $remember)) {
            
            // Jika login berhasil, regenerasi session untuk mencegah serangan session fixation
            $request->session()->regenerate();

            // 5. Mengecek tipe role user untuk diarahkan ke halaman yang benar
            if (auth()->user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif (auth()->user()->role === 'staff') {
                return redirect()->intended('/staff/dashboard');
            }

            // Jika role belum terdefinisikan, fallback ke routing aman (misal, user bisa dilogout/root)
            return redirect('/');
        }

        // 6. Jika login gagal, kembalikan user ke form login
        // Menyertakan pesan error pada field email
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // 1. Melakukan proses logout (menghapus data autentikasi user)
        Auth::logout();

        // 2. Menghapus data session (invalidasi)
        $request->session()->invalidate();

        // 3. Membuat ulang token CSRF (untuk keamanan saat mengakses form berikutnya)
        $request->session()->regenerateToken();

        // 4. Mengembalikan user ke halaman form login dan mengirim pesan sukses
        return redirect('/login')->with('success', 'Anda telah berhasil keluar dari sistem (Logout).');
    }
}
