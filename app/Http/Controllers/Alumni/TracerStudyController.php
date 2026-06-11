<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\TracerStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TracerStudyController extends Controller
{
    // Halaman Utama: Cek apakah sudah mengisi atau belum
    public function index()
    {
        $alumniId = Auth::user()->alumni->id;
        $tracer = TracerStudy::where('alumni_id', $alumniId)->first();

        // Arahkan ke view status
        return view('alumni.tracer.index', compact('tracer'));
    }

    // Form untuk membuat baru
    public function create()
    {
        return view('alumni.tracer.create');
    }

    // Proses simpan data baru
    public function store(Request $request)
    {
        $request->validate(['*' => 'required']); // Sesuaikan validasi dengan kolom Anda

        TracerStudy::create([
            'alumni_id' => Auth::user()->alumni->id,
            'status_pekerjaan' => $request->status_pekerjaan,
            // Tambahkan kolom lainnya...
        ]);

        return redirect()->route('alumni.tracer.index')->with('success', 'Data Tracer Study berhasil disimpan.');
    }

    // Form untuk Edit
    public function edit()
    {
        $tracer = TracerStudy::where('alumni_id', Auth::user()->alumni->id)->firstOrFail();
        return view('alumni.tracer.edit', compact('tracer'));
    }

    public function update(Request $request)
    {
    // Cek apakah alumni memiliki profil
    $alumni = Auth::user()->alumni;
    if (!$alumni) {

    return redirect()->route('alumni.tracer.index')
                 ->with('success', 'Data Tracer Study berhasil diperbarui!');
    }

    // 1. Validasi
    // Saya buat lebih longgar dulu untuk memastikan bukan ini penyebabnya
    $request->validate([
        'tahun_pengisian'   => 'required|integer',
        'status_aktivitas'  => 'required',
    ]);

    try {
        // 2. Simpan atau Update
        TracerStudy::updateOrCreate(
            [
                'alumni_id'       => $alumni->id,
                'tahun_pengisian' => $request->tahun_pengisian 
            ],
            [
                'status_aktivitas'   => $request->status_aktivitas,
                'nama_instansi'      => $request->nama_instansi,
                'jabatan'            => $request->jabatan,
                'kota_kerja'         => $request->kota_kerja,
                'masa_tunggu_bulan'  => $request->masa_tunggu_bulan,
                'keselarasan_kerja'  => $request->keselarasan_kerja,
                'pendapatan_ump'     => $request->pendapatan_ump,
                'nama_produk_usaha'  => $request->nama_produk_usaha,
                'bidang_usaha'       => $request->bidang_usaha,
                'kota_usaha'         => $request->kota_usaha,
                'keselarasan_usaha'  => $request->keselarasan_usaha,
                'keterangan_status'  => $request->keterangan_status,
                'negara_kerja'       => 'Indonesia',
            ]
        );

        return redirect()->back()->with('success', 'Data tahun ' . $request->tahun_pengisian . ' berhasil disimpan!');
    } catch (\Exception $e) {
        // Ini akan muncul di layar jika database gagal menyimpan
        return redirect()->back()->with('error', 'Error Database: ' . $e->getMessage());
    }
    }
}