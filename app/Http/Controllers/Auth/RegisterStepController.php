<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alumni;
use App\Models\Jurusan;
use App\Models\AlumniWhitelist;
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
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        // ============================================================
        // VERIFIKASI NISN — Pastikan calon pendaftar adalah alumni
        // SMKN Kintap yang sah berdasarkan data arsip sekolah.
        // ============================================================
        $nisn = trim($request->nisn);

        // Cek 1: Apakah NISN terdaftar di whitelist sekolah?
        if (!AlumniWhitelist::where('nisn', $nisn)->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'nisn' => 'NISN tidak ditemukan dalam data alumni SMKN Kintap. '
                            . 'Pastikan NISN Anda benar atau hubungi pihak sekolah.',
                ]);
        }

        // Cek 2: Apakah NISN ini sudah digunakan mendaftar sebelumnya?
        if (AlumniWhitelist::where('nisn', $nisn)->where('sudah_daftar', true)->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'nisn' => 'NISN ini sudah terdaftar di portal alumni. '
                            . 'Jika Anda lupa password, gunakan fitur lupa password.',
                ]);
        }

        // Cek 3: Jangan sampai NISN sudah ada di tabel alumnis (double-check)
        if (Alumni::where('nisn', $nisn)->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'nisn' => 'NISN ini sudah terdaftar. Gunakan fitur lupa password jika perlu.',
                ]);
        }
        // ============================================================

        $request->session()->put('register_data', [
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'nisn'     => $nisn, // Simpan NISN ke session agar step 2 konsisten
        ]);

        return redirect()->route('register.step2');
    }

    public function showStep2()
    {
        // Pastikan session dari step 1 ada, kalau tidak ada redirect balik
        if (!session()->has('register_data')) {
            return redirect()->route('register')
                ->withErrors(['nisn' => 'Sesi pendaftaran habis. Silakan mulai ulang.']);
        }

        return view('auth.register-step2');
    }

    public function processStep2(Request $request)
    {
        $data = $request->session()->get('register_data');

        // Guard: jika session hilang, tolak dan minta ulang dari step 1
        if (!$data) {
            return redirect()->route('register')
                ->withErrors(['nisn' => 'Sesi pendaftaran tidak valid. Silakan mulai ulang.']);
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'nisn'        => 'required|string|unique:alumnis,nisn',
            'tahun_lulus' => 'required|digits:4',
            'no_hp_wa'    => 'required|string',
            'jurusan'     => 'required|string|max:255',
        ]);

        // ============================================================
        // CROSS-CHECK NISN: Pastikan NISN di step 2 sama dengan yang
        // diverifikasi di step 1 (anti-manipulasi field tersembunyi).
        // ============================================================
        $nisnStep2 = trim($request->nisn);
        $nisnStep1 = $data['nisn'] ?? null;

        if ($nisnStep1 && $nisnStep2 !== $nisnStep1) {
            return back()
                ->withInput()
                ->withErrors([
                    'nisn' => 'NISN tidak sesuai dengan yang diverifikasi sebelumnya. '
                            . 'Harap ulangi pendaftaran dari awal.',
                ]);
        }

        // Verifikasi ulang whitelist di step 2 sebagai lapisan kedua keamanan
        if (!AlumniWhitelist::isValid($nisnStep2)) {
            return back()
                ->withInput()
                ->withErrors([
                    'nisn' => 'NISN tidak valid atau sudah terdaftar. Hubungi pihak sekolah.',
                ]);
        }
        // ============================================================

        // 1. Cari ID jurusan berdasarkan teks yang diketik
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
            'nisn'        => $nisnStep2,
            'tahun_lulus' => $request->tahun_lulus,
            'no_hp_wa'    => $request->no_hp_wa,
            'status_akun' => 'pending',
            'jurusan_id'  => $jurusanData ? $jurusanData->id : null,
            'jurusan'     => $request->jurusan,
        ]);

        // 4. Tandai NISN di whitelist sudah digunakan
        AlumniWhitelist::tandaiSudahDaftar($nisnStep2);

        $request->session()->forget('register_data');
        Auth::login($user);

        return redirect()->route('register.success')
            ->with('success', 'Registrasi berhasil! Akun Anda menunggu persetujuan Admin.');
    }
}