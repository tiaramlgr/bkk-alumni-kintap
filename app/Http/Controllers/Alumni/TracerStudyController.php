<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\TracerStudy;
use Illuminate\Http\Request;

class TracerStudyController extends Controller
{
    public function edit()
    {
        $tracer = auth()->user()->alumni->tracerStudy ?? new TracerStudy();
        return view('alumni.tracer.edit', compact('tracer'));
    }

    public function update(Request $request)
    {
        $alumni = auth()->user()->alumni;

        $request->validate([
            'status_aktivitas' => 'required|in:bekerja,wirausaha,kuliah,menganggur,lainnya',
            'keterangan_status' => 'nullable|string',
            'masa_tunggu_bulan' => 'nullable|integer',
            'jabatan' => 'nullable|string',
            'nama_instansi' => 'nullable|string',
            'kota_kerja' => 'nullable|string',
            'bidang_usaha' => 'nullable|string',
            'nama_produk_usaha' => 'nullable|string',
        ]);

        TracerStudy::updateOrCreate(
            ['alumni_id' => $alumni->id],
            array_merge($request->all(), ['tahun_pengisian' => date('Y')])
        );

        return redirect()->route('alumni.tracer.edit')
            ->with('success', 'Data Tracer Study berhasil disimpan!');
    }
}