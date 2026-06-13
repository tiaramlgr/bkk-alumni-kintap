<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Jurusan; // Pastikan ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfilController extends Controller
{
    public function edit()
    {
        $alumni = Auth::user()->alumni;
        // Mengirimkan nama jurusan untuk ditampilkan di input teks
        return view('alumni.profil.edit', compact('alumni'));
    }

    public function update(Request $request)
    {
        $alumni = Auth::user()->alumni;

        if (!$alumni) {
            return redirect()->back()->with('error', 'Data profil tidak ditemukan.');
        }

        $request->validate([
            'nik'           => 'required|string|max:20',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jurusan'       => 'required|string|max:100', // Teks yang diketik
            'tahun_lulus'   => 'required|integer',
            'no_hp_wa'      => 'required|string|max:20',
            'alamat'        => 'required|string',
        ]);

        // MENCARI ID JURUSAN BERDASARKAN TEKS YANG DIKETIK
        // Kita cari jurusan yang nama_kompetensi-nya sama dengan inputan
        $jurusanData = Jurusan::where('nama_kompetensi', $request->jurusan)->first();

        try {
            $alumni->update([
                'nik'             => $request->nik,
                'jenis_kelamin'   => $request->jenis_kelamin,
                'tempat_lahir'    => $request->tempat_lahir,
                'tanggal_lahir'   => $request->tanggal_lahir,
                'jurusan_id'      => $jurusanData ? $jurusanData->id : null, // SIMPAN ID NYA
                'tahun_lulus'     => $request->tahun_lulus,
                'no_hp_wa'        => $request->no_hp_wa,
                'alamat'          => $request->alamat,
                'is_subscribe_wa' => $request->has('is_subscribe_wa') ? 1 : 0,
            ]);

            return redirect()->route('alumni.profil.edit')->with('success', 'Profil Anda berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error('Gagal update profil alumni: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }
}