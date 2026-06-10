<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index()
    {
        $alumnis = Alumni::with('user', 'jurusan')
                         ->latest()
                         ->paginate(15);
        return view('admin.alumni.index', compact('alumnis'));
    }

    public function show($id)
    {
        $alumni = Alumni::with('user', 'jurusan', 'tracerStudy', 'dokumens', 'lamarans.lowongan')
                        ->findOrFail($id);
        return view('admin.alumni.show', compact('alumni'));
    }

    public function edit($id)
    {
        $alumni = Alumni::with('user')->findOrFail($id);
        return view('admin.alumni.edit', compact('alumni'));
    }

    public function update(Request $request, $id)
    {
        $alumni = Alumni::with('user')->findOrFail($id);

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $alumni->user_id,
            'no_hp_wa'     => 'nullable|string|max:20',
            'status_akun'  => 'required|in:pending,approved,rejected',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        // Update User data
        $alumni->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Update Alumni data
        $alumni->update([
            'no_hp_wa'           => $request->no_hp_wa,
            'status_akun'        => $request->status_akun,
            'catatan_verifikasi' => $request->catatan_verifikasi,
        ]);

        return redirect()->route('admin.alumni.index')
                         ->with('success', 'Data alumni berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);
        // Hapus user terkait juga
        $user = $alumni->user;
        $alumni->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.alumni.index')
                         ->with('success', 'Alumni berhasil dihapus!');
    }

    public function approve($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->update([
            'status_akun'        => 'approved',
            'catatan_verifikasi' => null,
        ]);

        return redirect()->back()
                         ->with('success', 'Alumni berhasil disetujui!');
    }

    public function reject(Request $request, $id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->update([
            'status_akun'        => 'rejected',
            'catatan_verifikasi' => $request->catatan,
        ]);

        return redirect()->back()
                         ->with('success', 'Alumni berhasil ditolak!');
    }
}