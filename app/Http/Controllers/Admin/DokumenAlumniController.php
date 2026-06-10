<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DokumenAlumni;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokumenAlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = DokumenAlumni::with('alumni.user', 'admin')->latest();

        if ($request->filled('alumni_id')) {
            $query->where('alumni_id', $request->alumni_id);
        }

        $dokumens = $query->paginate(15);
        $alumnis  = Alumni::with('user')->where('status_akun', 'approved')->get();

        return view('admin.dokumen.index', compact('dokumens', 'alumnis'));
    }

    public function create()
    {
        $alumnis = Alumni::with('user')->where('status_akun', 'approved')->get();
        return view('admin.dokumen.create', compact('alumnis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumni_id'     => 'required|exists:alumnis,id',
            'tipe_dokumen'  => 'required|string|max:100',
            'file_dokumen'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'tahun_dokumen' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        $file     = $request->file('file_dokumen');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/dokumen_alumni', $namaFile);

        DokumenAlumni::create([
            'alumni_id'     => $request->alumni_id,
            'admin_id'      => auth::id(),
            'tipe_dokumen'  => $request->tipe_dokumen,
            'nama_file'     => $file->getClientOriginalName(),
            'path_file'     => 'dokumen_alumni/' . $namaFile,
            'tahun_dokumen' => $request->tahun_dokumen,
            'is_active'     => true,
        ]);

        return redirect()->route('admin.dokumen.index')
                         ->with('success', 'Dokumen berhasil diunggah!');
    }

    public function show($id)
    {
        $dokumen = DokumenAlumni::with('alumni.user', 'admin')->findOrFail($id);
        return view('admin.dokumen.show', compact('dokumen'));
    }

    public function edit($id)
    {
        $dokumen = DokumenAlumni::findOrFail($id);
        $alumnis = Alumni::with('user')->where('status_akun', 'approved')->get();
        return view('admin.dokumen.edit', compact('dokumen', 'alumnis'));
    }

    public function update(Request $request, $id)
    {
        $dokumen = DokumenAlumni::findOrFail($id);

        $request->validate([
            'tipe_dokumen'  => 'required|string|max:100',
            'tahun_dokumen' => 'required|integer|min:2000|max:' . date('Y'),
            'file_dokumen'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'is_active'     => 'boolean',
        ]);

        $data = [
            'tipe_dokumen'  => $request->tipe_dokumen,
            'tahun_dokumen' => $request->tahun_dokumen,
            'is_active'     => $request->boolean('is_active'),
        ];

        if ($request->hasFile('file_dokumen')) {
            $file              = $request->file('file_dokumen');
            $namaFile          = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/dokumen_alumni', $namaFile);
            $data['nama_file'] = $file->getClientOriginalName();
            $data['path_file'] = 'dokumen_alumni/' . $namaFile;
        }

        $dokumen->update($data);

        return redirect()->route('admin.dokumen.index')
                         ->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $dokumen = DokumenAlumni::findOrFail($id);
        $dokumen->delete();

        return redirect()->route('admin.dokumen.index')
                         ->with('success', 'Dokumen berhasil dihapus!');
    }
}