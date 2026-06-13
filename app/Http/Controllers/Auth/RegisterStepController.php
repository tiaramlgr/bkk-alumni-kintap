<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alumni;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterStepController extends Controller
{
    public function showStep1()
    {
        return view('auth.register-step1');
    }

    public function processStep1(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $request->session()->put('register_data', [
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('register.step2');
    }

    public function showStep2()
    {
        return view('auth.register-step2');
    }

    public function processStep2(Request $request)
    {
    $data = $request->session()->get('register_data');

    $request->validate([
        'name'        => 'required|string|max:255',
        'nisn'        => 'required|string|unique:alumnis,nisn',
        'tahun_lulus' => 'required|digits:4',
        'no_hp_wa'    => 'required|string',
        'jurusan'     => 'required|string|max:255', 
    ]);

    // 1. CARI ID JURUSAN BERDASARKAN TEKS YANG DIKETIK
    // Kita cari nama_kompetensi yang sama dengan teks inputan
    $jurusanData = Jurusan::where('nama_kompetensi', $request->jurusan)->first();

    // 2. Buat User
    $user = User::create([
        'name'      => $request->name,
        'email'     => $data['email'],
        'password'  => $data['password'],
        'role'      => 'alumni',
        'is_active' => false,
    ]);

    // 3. Buat Profil Alumni
    Alumni::create([
        'user_id'     => $user->id,
        'nisn'        => $request->nisn,
        'tahun_lulus' => $request->tahun_lulus,
        'no_hp_wa'    => $request->no_hp_wa,
        'status_akun' => 'pending',
        // Jika input jurusan ditemukan, simpan ID-nya ke jurusan_id
        'jurusan_id'  => $jurusanData ? $jurusanData->id : null, 
        // Jika Anda tetap ingin menyimpan teksnya, simpan juga di kolom jurusan (jika ada)
        'jurusan'     => $request->jurusan, 
    ]);

    $request->session()->forget('register_data');
    Auth::login($user);

    return redirect()->route('register.success')
        ->with('success', 'Registrasi berhasil! Akun Anda menunggu persetujuan Admin.');
    }
}