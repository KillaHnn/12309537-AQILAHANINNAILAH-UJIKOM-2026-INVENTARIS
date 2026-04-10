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
        
    }
}
