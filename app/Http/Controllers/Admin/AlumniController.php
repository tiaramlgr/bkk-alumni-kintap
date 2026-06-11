<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data master jurusan untuk dropdown filter
        // Menggunakan try-catch agar jika tabel/model belum siap, tidak mencederai aplikasi
        $jurusans = [];
        if (class_exists('\App\Models\Jurusan')) {
            $jurusans = Jurusan::all();
        }

        // Query dasar data alumni beserta relasi user
        $query = Alumni::with(['user']);

        // Jalankan pencarian nama / NISN jika diinput pengguna
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nisn', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%")
                               ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan ID Jurusan dari Master Data
        if ($request->filled('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        // Filter berdasarkan Status Akun Verifikasi
        if ($request->filled('status_akun')) {
            $query->where('status_akun', $request->status_akun);
        }

        $alumnis = $query->latest()->paginate(10);

        return view('admin.alumni.index', compact('alumnis', 'jurusans'));
    }

    public function show($id)
    {
        $alumni = Alumni::with('user')->findOrFail($id);
        return view('admin.alumni.show', compact('alumni'));
    }

    public function edit($id)
    {
        $alumni = Alumni::findOrFail($id);
        $jurusans = class_exists('\App\Models\Jurusan') ? Jurusan::all() : [];
        return view('admin.alumni.edit', compact('alumni', 'jurusans'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email',
            'no_hp_wa'    => 'required|string|max:20',
            'status_akun' => 'required|in:pending,approved,rejected',
        ]);

        $alumni = Alumni::findOrFail($id);

        // 2. Update data User (Nama & Email)
        if ($alumni->user) {
            $alumni->user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);
        }

        // 3. Update data Alumni (Status, No HP, Catatan)
        $alumni->update([
            'no_hp_wa'           => $request->no_hp_wa,
            'status_akun'        => $request->status_akun,
            'catatan_verifikasi' => $request->catatan_verifikasi, // Pastikan kolom ini ada di database
        ]);

        // 4. Sinkronisasi status aktif user (Opsional: agar login bisa/tidak)
        if ($alumni->user) {
            $alumni->user->update(['is_active' => ($request->status_akun === 'approved')]);
        }

        return redirect()->route('admin.alumni.index')->with('success', 'Data alumni berhasil diperbarui.');
    }

    public function approve($id)
    {
        $alumni = Alumni::findOrFail($id);
        
        // Mengubah status di tabel alumnis
        $alumni->update(['status_akun' => 'approved']);
        
        // Jika Anda juga perlu mengupdate is_active di tabel users
        if ($alumni->user) {
            $alumni->user->update(['is_active' => true]);
        }

        return redirect()->back()->with('success', 'Alumni telah disetujui (Approved).');
    }

    public function reject($id)
    {
        $alumni = Alumni::findOrFail($id);
        
        // Mengubah status di tabel alumnis
        $alumni->update(['status_akun' => 'rejected']);
        
        // Menonaktifkan user
        if ($alumni->user) {
            $alumni->user->update(['is_active' => false]);
        }

        return redirect()->back()->with('success', 'Alumni telah ditolak (Rejected).');
    }

    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);
        if ($alumni->user) {
            $alumni->user->delete();
        }
        $alumni->delete();

        return redirect()->route('admin.alumni.index')->with('success', 'Akun dan data alumni berhasil dihapus secara permanen.');
    }
}