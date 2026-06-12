<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DokumenAlumni;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class DokumenAlumniController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = DokumenAlumni::with(['alumni.user', 'admin'])->latest();

            if ($request->filled('alumni_id')) {
                $query->where('alumni_id', $request->alumni_id);
            }

            $dokumens = $query->paginate(15);
            $alumnis  = Alumni::with('user')->where('status_akun', 'approved')->get();

            return view('admin.dokumen.index', compact('dokumens', 'alumnis'));
        } catch (\Throwable $th) {
            dd('ERROR INDEX ADMIN:', $th->getMessage());
        }
    }

    public function create()
    {
        try {
            $alumnis = Alumni::with('user')->where('status_akun', 'approved')->get();
            return view('admin.dokumen.create', compact('alumnis'));
        } catch (\Throwable $th) {
            dd('ERROR CREATE ADMIN:', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'alumni_id'     => 'required|exists:alumnis,id',
                'tipe_dokumen'  => 'required|string|max:100',
                'file_dokumen' => 'required|file|mimes:pdf,jpg,png|max:5120',
                'tahun_dokumen' => 'required|integer|min:2000|max:' . date('Y'),
            ]);

            $file = $request->file('file_dokumen');
            
            // BIKIN NAMA FILE AMAN
            $ext = $file->getClientOriginalExtension();
            $namaFile = time() . '_' . uniqid() . '.' . $ext;
            
            // JURUS ANTI-BUG LARAGON: Gunakan fungsi move() langsung ke folder public/storage
            $destinationPath = public_path('storage/dokumen_admin');
            
            // Pastikan folder tersedia, jika belum maka buat otomatis
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Pindahkan file secara fisik (Bypass Flysystem)
            $file->move($destinationPath, $namaFile);

            DokumenAlumni::create([
                'alumni_id'         => $request->alumni_id,
                'admin_id'          => Auth::id(),
                'tipe_dokumen'      => $request->tipe_dokumen,
                'nama_file'         => $file->getClientOriginalName(), // Simpan nama asli
                'path_file'         => 'dokumen_admin/' . $namaFile,
                'tahun_dokumen'     => $request->tahun_dokumen,
                'is_active'         => true,
            ]);

            return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil diunggah ke akun alumni!');
            
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            dd('ERROR STORE ADMIN:', $th->getMessage(), 'BARIS:', $th->getLine());
        }
    }

    public function show($id)
    {
        try {
            $dokumen = DokumenAlumni::with(['alumni.user', 'admin'])->findOrFail($id);
            return view('admin.dokumen.show', compact('dokumen'));
        } catch (\Throwable $th) {
            dd('ERROR SHOW ADMIN:', $th->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $dokumen = DokumenAlumni::findOrFail($id);
            $alumnis = Alumni::with('user')->where('status_akun', 'approved')->get();
            return view('admin.dokumen.edit', compact('dokumen', 'alumnis'));
        } catch (\Throwable $th) {
            dd('ERROR EDIT ADMIN:', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $dokumen = DokumenAlumni::findOrFail($id);

            $request->validate([
                'tipe_dokumen'  => 'required|string|max:100',
                'tahun_dokumen' => 'required|integer|min:2000|max:' . date('Y'),
                'file_dokumen'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ]);

            $data = [
                'tipe_dokumen'  => $request->tipe_dokumen,
                'tahun_dokumen' => $request->tahun_dokumen,
                'is_active'     => $request->has('is_active'),
            ];

            if ($request->hasFile('file_dokumen')) {
                // Hapus file lama fisik dengan aman
                $oldPath = public_path('storage/' . $dokumen->path_file);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }

                $file = $request->file('file_dokumen');
                $ext = $file->getClientOriginalExtension();
                $namaFile = time() . '_' . uniqid() . '.' . $ext;
                
                $destinationPath = public_path('storage/dokumen_admin');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $namaFile);
                
                $data['nama_file'] = $file->getClientOriginalName();
                $data['path_file'] = 'dokumen_admin/' . $namaFile;
            }

            $dokumen->update($data);

            return redirect()->route('admin.dokumen.index')->with('success', 'Perubahan dokumen berhasil disimpan!');
            
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            dd('ERROR UPDATE ADMIN:', $th->getMessage(), 'BARIS:', $th->getLine());
        }
    }

    public function destroy($id)
    {
        try {
            $dokumen = DokumenAlumni::findOrFail($id);
            
            // Hapus file fisik
            $filePath = public_path('storage/' . $dokumen->path_file);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            
            $dokumen->delete();
            return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen beserta filenya berhasil dihapus!');
            
        } catch (\Throwable $th) {
            dd('ERROR DESTROY ADMIN:', $th->getMessage());
        }
    }
}