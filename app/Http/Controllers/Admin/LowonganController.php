<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LowonganKerja;
use App\Models\KategoriLowongan;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    public function index()
    {
        $lowongans = LowonganKerja::with('kategori')->latest()->get();
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
            'judul_lowongan' => 'required|string|max:255',
            'nama_perusahaan' => 'required|string',
            'lokasi' => 'required|string',
            'tipe_pekerjaan' => 'required',
            'deskripsi' => 'required',
            'kualifikasi' => 'required',
            'deadline' => 'required|date',
            'kategori_id' => 'required|exists:kategori_lowongans,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'admin_id'       => auth()->id(),
            'kategori_id'    => $request->kategori_id,
            'judul_lowongan' => $request->judul_lowongan,
            'nama_perusahaan'=> $request->nama_perusahaan,
            'lokasi'         => $request->lokasi,
            'tipe_pekerjaan' => $request->tipe_pekerjaan,
            'deskripsi'      => $request->deskripsi,
            'kualifikasi'    => $request->kualifikasi,
            'deadline'       => $request->deadline,
            'status'         => 'aktif',
            'siaran_wa'      => $request->has('siaran_wa'),
        ];

        // Upload Foto jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/lowongan', $namaFoto);
            $data['foto'] = 'lowongan/' . $namaFoto;
        }

        LowonganKerja::create($data);

        return redirect()->route('admin.lowongan.index')
                         ->with('success', 'Lowongan berhasil diposting!');
    }
}