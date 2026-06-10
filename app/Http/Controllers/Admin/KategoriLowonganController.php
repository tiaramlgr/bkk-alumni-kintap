<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriLowongan;
use Illuminate\Http\Request;

class KategoriLowonganController extends Controller
{
    public function index()
    {
        // Mengambil data kategori dengan hitungan lowongan terikat
        $kategoris = KategoriLowongan::withCount('lowongans')->latest()->paginate(10);
        return view('admin.kategori-lowongan.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori-lowongan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_lowongans,nama_kategori',
            'icon'          => 'nullable|string|max:100',
        ]);

        KategoriLowongan::create([
            'nama_kategori' => $request->nama_kategori,
            'icon'          => $request->icon ?? 'fas fa-briefcase',
        ]);

        return redirect()->route('admin.kategori-lowongan.index')
                         ->with('success', 'Kategori lowongan kerja baru berhasil disimpan.');
    }

    public function show($id)
    {
        $kategori = KategoriLowongan::withCount('lowongans')->findOrFail($id);
        return view('admin.kategori-lowongan.show', compact('kategori'));
    }
    
    public function edit($id)
    {
        // Mengambil ID secara mentah dari parameter router untuk mencegah interrupted bypass
        $kategori = KategoriLowongan::findOrFail($id);
        return view('admin.kategori-lowongan.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_lowongans,nama_kategori,' . $id,
            'icon'          => 'nullable|string|max:100',
        ]);

        $kategori = KategoriLowongan::findOrFail($id);
        $kategori->update($request->only(['nama_kategori', 'icon']));

        return redirect()->route('admin.kategori-lowongan.index')
                         ->with('success', 'Kategori lowongan kerja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriLowongan::findOrFail($id);
        
        if ($kategori->lowongans()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena masih terikat dengan lowongan kerja aktif.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori-lowongan.index')
                         ->with('success', 'Kategori lowongan berhasil dihapus.');
    }
}