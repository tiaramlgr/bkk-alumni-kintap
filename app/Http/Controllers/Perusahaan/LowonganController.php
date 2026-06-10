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

    /**
     * Menyimpan data lowongan kerja baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_lowongan'  => 'required|string|max:255',
            'nama_perusahaan' => 'required|string|max:255',
            'lokasi'          => 'required|string|max:255',
            'tipe_pekerjaan'  => 'required|string',
            'deskripsi'       => 'required|string',
            'kualifikasi'     => 'required|string',
            'deadline'        => 'required|date',
            'kategori_id'     => 'required|exists:kategori_lowongans,id',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'judul_lowongan', 'nama_perusahaan', 'lokasi', 
            'tipe_pekerjaan', 'deskripsi', 'kualifikasi', 'deadline', 'kategori_id'
        ]);
        
        $data['admin_id']  = Auth::id(); // Mengikat lowongan ke user perusahaan
        $data['status']    = 'aktif';
        $data['siaran_wa'] = $request->has('siaran_wa');

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/lowongan', $namaFoto);
            $data['foto'] = 'lowongan/' . $namaFoto;
        }

        LowonganKerja::create($data);

        return redirect()->route('perusahaan.lowongan.index')
                         ->with('success', 'Lowongan kerja berhasil dipublikasikan.');
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_lowongan'  => 'required|string|max:255',
            'nama_perusahaan' => 'required|string|max:255',
            'lokasi'          => 'required|string|max:255',
            'tipe_pekerjaan'  => 'required|string',
            'deskripsi'       => 'required|string',
            'kualifikasi'     => 'required|string',
            'deadline'        => 'required|date',
            'kategori_id'     => 'required|exists:kategori_lowongans,id',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $lowongan = LowonganKerja::where('admin_id', Auth::id())->findOrFail($id);
        
        $data = $request->only([
            'judul_lowongan', 'nama_perusahaan', 'lokasi', 
            'tipe_pekerjaan', 'deskripsi', 'kualifikasi', 'deadline', 'kategori_id'
        ]);
        $data['siaran_wa'] = $request->has('siaran_wa');

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/lowongan', $namaFoto);
            $data['foto'] = 'lowongan/' . $namaFoto;
        }

        $lowongan->update($data);

        return redirect()->route('perusahaan.lowongan.index')
                         ->with('success', 'Lowongan kerja berhasil diperbarui.');
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