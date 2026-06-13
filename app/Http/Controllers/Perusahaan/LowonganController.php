<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Models\LowonganKerja;
use App\Models\KategoriLowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LowonganController extends Controller
{
    /**
     * Menampilkan daftar lowongan khusus milik perusahaan yang sedang login.
     */
    public function index()
    {
        // Mengambil lowongan yang dibuat oleh admin_id (User ID Perusahaan ini)
        $lowongans = LowonganKerja::with('kategori')
            ->where('admin_id', Auth::id())
            ->latest()
            ->get();

        return view('perusahaan.lowongan.index', compact('lowongans'));
    }

    /**
     * Menampilkan form buat lowongan baru.
     */
    public function create()
    {
        $kategoris = KategoriLowongan::all();
        return view('perusahaan.lowongan.create', compact('kategoris'));
    }

// --- 1. FUNGSI STORE ---
    public function store(Request $request)
    {
        $request->validate([
            'judul_lowongan' => 'required|string|max:255',
            'lokasi'         => 'required|string|max:255',
            'tipe_pekerjaan' => 'required|string|max:255',
            'kategori_id'    => 'required|exists:kategori_lowongans,id',
            'deskripsi'      => 'required|string',
            'kualifikasi'    => 'required|string',
            'deadline'       => 'required|date',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Tambahan Validasi Foto
        ]);

        $user = auth()->user();
        $perusahaan = $user->company;

        $data = [
            'admin_id'        => $user->id,
            'kategori_id'     => $request->kategori_id,
            'judul_lowongan'  => $request->judul_lowongan,
            'nama_perusahaan' => $perusahaan->nama_perusahaan ?? $user->name,
            'lokasi'          => $request->lokasi,
            'tipe_pekerjaan'  => $request->tipe_pekerjaan,
            'deskripsi'       => $request->deskripsi,
            'kualifikasi'     => $request->kualifikasi,
            'deadline'        => $request->deadline,
            'status'          => 'aktif', 
            'siaran_wa'       => 0, 
        ];

        // JURUS ULTIMATE UPLOAD FOTO
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $ext = $foto->getClientOriginalExtension() ?: 'png';
            $namaFoto = 'poster_pt_' . time() . '_' . uniqid() . '.' . $ext;
            
            $tujuan_upload = storage_path('app/public/lowongan');
            $foto->move($tujuan_upload, $namaFoto);
            
            $data['foto'] = 'lowongan/' . $namaFoto;
        }

        \App\Models\LowonganKerja::create($data);

        return redirect()->route('perusahaan.lowongan.index')
                         ->with('success', 'Lowongan kerja dan poster berhasil dipublikasikan!');
    }

    /**
     * Menampilkan form edit lowongan kerja milik perusahaan.
     */
    public function edit($id)
    {
        $lowongan = LowonganKerja::where('admin_id', Auth::id())->findOrFail($id);
        $kategoris = KategoriLowongan::all();
        
        return view('perusahaan.lowongan.edit', compact('lowongan', 'kategoris'));
    }

    /**
     * Memperbarui data lowongan kerja di database.
     */
// --- 2. FUNGSI UPDATE ---
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_lowongan' => 'required|string|max:255',
            'lokasi'         => 'required|string|max:255',
            'tipe_pekerjaan' => 'required|string|max:255',
            'kategori_id'    => 'required|exists:kategori_lowongans,id',
            'deskripsi'      => 'required|string',
            'kualifikasi'    => 'required|string',
            'deadline'       => 'required|date',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Tambahan Validasi Foto
        ]);

        $lowongan = \App\Models\LowonganKerja::findOrFail($id);
        
        $data = $request->only([
            'judul_lowongan', 'lokasi', 'tipe_pekerjaan', 
            'deskripsi', 'kualifikasi', 'deadline', 'kategori_id'
        ]);

        // JURUS ULTIMATE UPLOAD FOTO (TIMPA FOTO LAMA)
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $ext = $foto->getClientOriginalExtension() ?: 'png';
            $namaFoto = 'poster_pt_' . time() . '_' . uniqid() . '.' . $ext;
            
            $tujuan_upload = storage_path('app/public/lowongan');
            $foto->move($tujuan_upload, $namaFoto);
            
            $data['foto'] = 'lowongan/' . $namaFoto;
        }

        $lowongan->update($data);

        return redirect()->route('perusahaan.lowongan.index')
                         ->with('success', 'Lowongan berhasil diperbarui!');
    }

    // --- 3. FUNGSI UPDATE STATUS PELAMAR ---
    public function updateStatusLamaran(Request $request, $id)
    {
        $lamaran = \App\Models\Lamaran::findOrFail($id);
        
        $lamaran->update([
            'status_lamaran' => $request->status_lamaran,
            'catatan_admin'  => $request->catatan_admin // Ini bisa dipakai sebagai catatan HRD Perusahaan
        ]);

        return redirect()->back()->with('success', 'Status pelamar berhasil diperbarui menjadi ' . $request->status_lamaran);
    }
   
    public function show($id)
    {
        // Ambil data lowongan beserta relasi kategorinya
        $lowongan = \App\Models\LowonganKerja::with('kategori')->findOrFail($id);
        
        return view('perusahaan.lowongan.show', compact('lowongan'));
    }
    
    /**
     * Menghapus lowongan kerja milik perusahaan.
     */
    public function destroy($id)
    {
        $lowongan = LowonganKerja::where('admin_id', Auth::id())->findOrFail($id);
        $lowongan->delete();

        return redirect()->route('perusahaan.lowongan.index')
                         ->with('success', 'Lowongan kerja berhasil dihapus.');
    }
}