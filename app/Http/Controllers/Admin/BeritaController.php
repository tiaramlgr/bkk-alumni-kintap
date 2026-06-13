<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::with('admin')->latest()->paginate(10);
        return view('admin.berita.index', compact('beritas'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'  => 'required|string|max:255',
            'konten' => 'required|string',
            'foto'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $data = [
            'admin_id' => Auth::id(),
            'judul'    => $request->judul,
            'slug'     => Str::slug($request->judul) . '-' . time(),
            'konten'   => $request->konten,
            'status'   => $request->status,
        ];

        // Jurus Upload Aman
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = 'berita_' . time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->move(storage_path('app/public/berita'), $namaFoto);
            $data['foto'] = 'berita/' . $namaFoto;
        }

        Berita::create($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function show($id)
    {
        // Mencari berita berdasarkan ID, jika tidak ketemu akan memunculkan error 404
        $berita = Berita::with('admin')->findOrFail($id);
        
        // Mengembalikan tampilan detail berita
        return view('admin.berita.show', compact('berita'));
    }
    
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'  => 'required|string|max:255',
            'konten' => 'required|string',
            'foto'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $berita = Berita::findOrFail($id);
        $data = $request->only(['judul', 'konten', 'status']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($berita->foto && File::exists(storage_path('app/public/' . $berita->foto))) {
                File::delete(storage_path('app/public/' . $berita->foto));
            }

            $foto = $request->file('foto');
            $namaFoto = 'berita_' . time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->move(storage_path('app/public/berita'), $namaFoto);
            $data['foto'] = 'berita/' . $namaFoto;
        }

        $berita->update($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        if ($berita->foto && File::exists(storage_path('app/public/' . $berita->foto))) {
            File::delete(storage_path('app/public/' . $berita->foto));
        }
        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}