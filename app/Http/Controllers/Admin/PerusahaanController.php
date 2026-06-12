<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company; // Pastikan ini sesuai dengan nama Model database Anda
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    // Menampilkan daftar perusahaan
    public function index()
    {
        $perusahaans = Company::latest()->paginate(10);
        return view('admin.perusahaan.index', compact('perusahaans'));
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $perusahaan = Company::findOrFail($id);
        return view('admin.perusahaan.edit', compact('perusahaan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'sektor_industri' => 'required|string|max:100',
            'email_kantor'    => 'nullable|email|max:255', 
            'no_hp_wa'        => 'nullable|string|max:20', 
            'alamat'          => 'nullable|string',
        ]);

        $perusahaan = Company::findOrFail($id);
        $perusahaan->update($request->all());

        return redirect()->route('admin.perusahaan.index')
                         ->with('success', 'Data perusahaan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $perusahaan = Company::findOrFail($id);
        
        // 1. Tangkap ID user sebelum perusahaan dihapus
        $userId = $perusahaan->user_id;

        // 2. Hapus profil perusahaannya
        $perusahaan->delete();

        // 3. JURUS SAPU BERSIH: Hapus akun login menembus batas model/soft-deletes
        if ($userId != null) {
            // Kita gunakan DB::table agar perintah tembus langsung ke jantung MySQL
            \Illuminate\Support\Facades\DB::table('users')->where('id', $userId)->delete();
        }

        return redirect()->route('admin.perusahaan.index')
                         ->with('success', 'Data perusahaan beserta akun loginnya berhasil dimusnahkan!');
        }
}