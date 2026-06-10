<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TracerStudy;
use App\Models\Alumni;
use Illuminate\Http\Request;

class TracerStudyController extends Controller
{
    public function index()
    {
        $tracers = TracerStudy::with('alumni.user', 'alumni.jurusan')
                               ->latest()
                               ->paginate(15);
        return view('admin.tracer.index', compact('tracers'));
    }

    public function create()
    {
        // Admin bisa buat tracer study untuk alumni yang belum punya
        $alumnis = Alumni::with('user')
                         ->where('status_akun', 'approved')
                         ->doesntHave('tracerStudy')
                         ->get();
        return view('admin.tracer.create', compact('alumnis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumni_id'          => 'required|exists:alumnis,id|unique:tracer_studies,alumni_id',
            'tahun_pengisian'    => 'required|integer|min:2000|max:' . date('Y'),
            'status_aktivitas'   => 'required|in:bekerja,wirausaha,kuliah,belum_bekerja,lainnya',
            'keterangan_status'  => 'nullable|string',
        ]);

        TracerStudy::create($request->only([
            'alumni_id', 'tahun_pengisian', 'status_aktivitas', 'keterangan_status',
            'masa_tunggu_bulan', 'jabatan', 'nama_instansi', 'kota_kerja',
            'negara_kerja', 'keselarasan_kerja', 'bidang_usaha', 'kota_usaha',
            'keselarasan_usaha', 'nama_produk_usaha', 'pendapatan_ump', 'pendapatan_umk',
        ]));

        return redirect()->route('admin.tracer.index')
                         ->with('success', 'Data Tracer Study berhasil ditambahkan!');
    }

    public function show($id)
    {
        $tracer = TracerStudy::with('alumni.user', 'alumni.jurusan')->findOrFail($id);
        return view('admin.tracer.show', compact('tracer'));
    }

    public function edit($id)
    {
        $tracer  = TracerStudy::with('alumni.user')->findOrFail($id);
        $alumnis = Alumni::with('user')->where('status_akun', 'approved')->get();
        return view('admin.tracer.edit', compact('tracer', 'alumnis'));
    }

    public function update(Request $request, $id)
    {
        $tracer = TracerStudy::findOrFail($id);

        $request->validate([
            'tahun_pengisian'   => 'required|integer|min:2000|max:' . date('Y'),
            'status_aktivitas'  => 'required|in:bekerja,wirausaha,kuliah,belum_bekerja,lainnya',
            'keterangan_status' => 'nullable|string',
        ]);

        $tracer->update($request->only([
            'tahun_pengisian', 'status_aktivitas', 'keterangan_status',
            'masa_tunggu_bulan', 'jabatan', 'nama_instansi', 'kota_kerja',
            'negara_kerja', 'keselarasan_kerja', 'bidang_usaha', 'kota_usaha',
            'keselarasan_usaha', 'nama_produk_usaha', 'pendapatan_ump', 'pendapatan_umk',
        ]));

        return redirect()->route('admin.tracer.index')
                         ->with('success', 'Data Tracer Study berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $tracer = TracerStudy::findOrFail($id);
        $tracer->delete();

        return redirect()->route('admin.tracer.index')
                         ->with('success', 'Data Tracer Study berhasil dihapus!');
    }
}