<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerusahaanRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('perusahaan.auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi disesuaikan dengan apa yang benar-benar ada di form
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:6|confirmed',
            'no_hp_wa'        => 'required|string', 
            'alamat'          => 'nullable|string',
        ], [
            // Tambahan opsional: Pesan error bahasa Indonesia agar lebih rapi
            'nama_perusahaan.required' => 'Nama perusahaan wajib diisi.',
            'no_hp_wa.required'        => 'Nomor Telepon / WA wajib diisi.',
            'email.unique'             => 'Email ini sudah terdaftar.',
            'password.confirmed'       => 'Konfirmasi password tidak cocok.'
        ]);

        // 2. Buat Akun Login (Tabel users)
        $user = User::create([
            // Gunakan nama_perusahaan untuk mengisi kolom name
            'name'     => $request->nama_perusahaan, 
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'perusahaan',
        ]);

        // 3. Buat Profil Perusahaan (Tabel companies)
        Company::create([
            'user_id'         => $user->id,
            'nama_perusahaan' => $request->nama_perusahaan,
            'no_hp_wa'        => $request->no_hp_wa,
            // Jika Anda menambahkan kolom email_kantor di tabel companies, uncomment baris di bawah:
            // 'email_kantor' => $request->email,
            'alamat'          => $request->alamat,
        ]);

        // 4. Login otomatis setelah mendaftar
        auth()->login($user);

        return redirect()->route('perusahaan.dashboard');
    }
}