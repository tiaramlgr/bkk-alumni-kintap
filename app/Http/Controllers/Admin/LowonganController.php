<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LowonganKerja;
use App\Models\KategoriLowongan;
use App\Models\Lamaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LowonganController extends Controller
{
    public function index()
    {
        // Mengambil SEMUA lowongan dari seluruh pembuat (Admin & Semua Perusahaan)
        $lowongans = LowonganKerja::with('admin', 'kategori')->latest()->get();
        
        return view('admin.lowongan.index', compact('lowongans'));
    }

    public function create()
    {
        $kategoris = KategoriLowongan::all();
        return view('admin.lowongan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_lowongan'  => 'required|string|max:255',
            'nama_perusahaan' => 'required|string',
            'lokasi'          => 'required|string',
            'tipe_pekerjaan'  => 'required',
            'deskripsi'       => 'required',
            'kualifikasi'     => 'required',
            'deadline'        => 'required|date',
            'kategori_id'     => 'required|exists:kategori_lowongans,id',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'judul_lowongan', 'nama_perusahaan', 'lokasi', 'tipe_pekerjaan',
            'deskripsi', 'kualifikasi', 'deadline', 'kategori_id'
        ]);
        
        $data['admin_id'] = Auth::id(); 
        $data['status'] = 'aktif';
        $data['siaran_wa'] = $request->has('siaran_wa');

        // JURUS ULTIMATE: Bypass Flysystem, gunakan move() langsung
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $ext = $foto->getClientOriginalExtension() ?: 'png';
            $namaFoto = 'foto_' . time() . '_' . uniqid() . '.' . $ext;
            
            $tujuan_upload = storage_path('app/public/lowongan');
            $foto->move($tujuan_upload, $namaFoto);
            
            $data['foto'] = 'lowongan/' . $namaFoto;
        }

        // Murni hanya menyimpan ke database saja
        LowonganKerja::create($data);

        return redirect()->route('admin.lowongan.index')
                         ->with('success', 'Lowongan berhasil dibuat.');
    }

    public function edit($id)
    {
        $lowongan = LowonganKerja::findOrFail($id);
        $kategoris = KategoriLowongan::all();
        return view('admin.lowongan.edit', compact('lowongan', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_lowongan'  => 'required|string|max:255',
            'nama_perusahaan' => 'required|string',
            'lokasi'          => 'required|string',
            'tipe_pekerjaan'  => 'required',
            'deskripsi'       => 'required',
            'kualifikasi'     => 'required',
            'deadline'        => 'required|date',
            'kategori_id'     => 'required|exists:kategori_lowongans,id',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $lowongan = LowonganKerja::findOrFail($id);
        $data = $request->only([
            'judul_lowongan', 'nama_perusahaan', 'lokasi', 'tipe_pekerjaan', 
            'deskripsi', 'kualifikasi', 'deadline', 'kategori_id'
        ]);
        $data['siaran_wa'] = $request->has('siaran_wa');

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $ext = $foto->getClientOriginalExtension() ?: 'png';
            $namaFoto = 'foto_' . time() . '_' . uniqid() . '.' . $ext;
            
            $tujuan_upload = storage_path('app/public/lowongan');
            $foto->move($tujuan_upload, $namaFoto);
            
            $data['foto'] = 'lowongan/' . $namaFoto;
        }

        $lowongan->update($data);

        return redirect()->route('admin.lowongan.index')
                         ->with('success', 'Sip! Data lowongan kerja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lowongan = LowonganKerja::findOrFail($id);
        $lowongan->delete();

        return redirect()->route('admin.lowongan.index')
                         ->with('success', 'Lowongan berhasil dihapus!');
    }

    public function show($id)
    {
        $lowongan = LowonganKerja::with('kategori', 'admin')->findOrFail($id);
        return view('admin.lowongan.show', compact('lowongan'));
    }

    public function pelamar($id)
    {
        $lowongan = LowonganKerja::findOrFail($id);
        $lamarans = Lamaran::with(['alumni.user', 'alumni.jurusan'])
                           ->where('lowongan_id', $id)
                           ->latest()
                           ->paginate(10);
                           
        return view('admin.lowongan.pelamar', compact('lowongan', 'lamarans'));
    }

    public function updateStatusLamaran(Request $request, $id)
    {
        $lamaran = \App\Models\Lamaran::findOrFail($id);
        
        $lamaran->update([
            'status_lamaran' => $request->status_lamaran,
            'catatan_admin'  => $request->catatan_admin
        ]);

        return redirect()->back()->with('success', 'Status lamaran berhasil diperbarui menjadi ' . $request->status_lamaran);
    }
}