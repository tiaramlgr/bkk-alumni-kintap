<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::latest()->paginate(10);
        return view('admin.jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        return view('admin.jurusan.create');
    }

    public function store(Request $request)
    {
        // Validasi disesuaikan dengan struktur database Anda
        $request->validate([
            'kode_jurusan'    => 'required|string|max:255|unique:jurusans,kode_jurusan',
            'nama_kompetensi' => 'required|string|max:255',
            'nama_program'    => 'required|string|max:255',
            'nama_bidang'     => 'required|string|max:255',
        ]);

        Jurusan::create([
            'kode_jurusan'    => $request->kode_jurusan,
            'nama_kompetensi' => $request->nama_kompetensi,
            'nama_program'    => $request->nama_program,
            'nama_bidang'     => $request->nama_bidang,
            'is_active'       => true,
        ]);

        return redirect()->route('admin.jurusan.index')
                         ->with('success', 'Data Kompetensi Keahlian berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('admin.jurusan.show', compact('jurusan'));
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_jurusan'    => 'required|string|max:255|unique:jurusans,kode_jurusan,' . $id,
            'nama_kompetensi' => 'required|string|max:255',
            'nama_program'    => 'required|string|max:255',
            'nama_bidang'     => 'required|string|max:255',
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update([
            'kode_jurusan'    => $request->kode_jurusan,
            'nama_kompetensi' => $request->nama_kompetensi,
            'nama_program'    => $request->nama_program,
            'nama_bidang'     => $request->nama_bidang,
        ]);

        return redirect()->route('admin.jurusan.index')
                         ->with('success', 'Data Jurusan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('admin.jurusan.index')
                         ->with('success', 'Data Jurusan berhasil dihapus.');
    }
}