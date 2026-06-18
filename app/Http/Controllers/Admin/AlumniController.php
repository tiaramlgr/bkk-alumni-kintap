<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Imports\AlumniImport;
use Maatwebsite\Excel\Facades\Excel;

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

    /**
     * Import Data Alumni dari file CSV 
     */
     public function importCsv(Request $request)
    {
        $request->validate(['file_csv' => 'required']);
        $file = $request->file('file_csv');

        // Pindahkan file untuk mencegah diblokir Windows
        $nama_file = time() . '_import.csv';
        $tujuan_upload = storage_path('app/public');
        $file->move($tujuan_upload, $nama_file);
        $path_aman = $tujuan_upload . '/' . $nama_file;

        if (($handle = fopen($path_aman, 'r')) !== false) {
            
            // 1. Deteksi Pemisah (Koma atau Titik Koma) Otomatis
            $firstLine = fgets($handle);
            $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';
            rewind($handle);

            // 2. Cari Baris Judul (Header)
            $header = [];
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $rowStr = strtolower(implode('', $row));
                // Jika baris ini memiliki kata 'nama', anggap ini adalah baris judul kolom
                if (strpos($rowStr, 'nama') !== false) {
                    $header = array_map('trim', array_map('strtolower', $row));
                    break;
                }
            }

            if (empty($header)) {
                fclose($handle);
                @unlink($path_aman);
                return redirect()->back()->with('error', 'Gagal menemukan judul kolom. Pastikan ada kolom NAMA ALUMNI atau NAMA LENGKAP.');
            }

            // 3. Pencarian Posisi Kolom Otomatis (Auto-Map)
            $idx_nama = -1; $idx_nisn = -1; $idx_nohp = -1; $idx_email = -1; $idx_tahun = -1;

            foreach ($header as $i => $col) {
                // Kenali variasi penamaan kolom dari berbagai tahun file Anda
                if ($col === 'nama' || $col === 'nama alumni' || $col === 'nama lengkap') $idx_nama = $i;
                if ($col === 'nisn') $idx_nisn = $i;
                if ($col === 'no. hp' || $col === 'no hp' || str_contains($col, 'hp')) $idx_nohp = $i;
                if ($col === 'email' || $col === 'e-mail') $idx_email = $i;
                if ($col === 'tahun lulus' || str_contains($col, 'tahun')) $idx_tahun = $i;
            }

            // Jika masih gagal menemukan kolom nama
            if ($idx_nama === -1) {
                fclose($handle);
                @unlink($path_aman);
                return redirect()->back()->with('error', 'Sistem tidak bisa menemukan kolom Nama. Cek nama kolom di CSV Anda.');
            }

            $berhasil = 0;

            // 4. Proses Input Data dengan Cerdas
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                // Lewati jika nama kosong
                if (!isset($row[$idx_nama]) || trim($row[$idx_nama]) === '') {
                    continue;
                }

                $nama_lengkap = trim($row[$idx_nama]);

                // Ekstrak data HANYA JIKA kolomnya ada di file tersebut
                $nisn_asli    = ($idx_nisn !== -1 && isset($row[$idx_nisn])) ? trim($row[$idx_nisn]) : '';
                $no_hp        = ($idx_nohp !== -1 && isset($row[$idx_nohp])) ? trim($row[$idx_nohp]) : '';
                $email_asli   = ($idx_email !== -1 && isset($row[$idx_email])) ? trim($row[$idx_email]) : '';
                $tahun_lulus  = ($idx_tahun !== -1 && isset($row[$idx_tahun])) ? trim($row[$idx_tahun]) : '';

                // Buat NISN Acak HANYA jika file (seperti tahun 2021-2024) tidak memiliki kolom NISN
                $nisn = ($nisn_asli !== '' && $nisn_asli !== '-') ? $nisn_asli : 'ALM' . rand(100000, 999999);

                // Buat Email Unik untuk akun yang tidak ada email / format emailnya rusak
                if ($email_asli === '' || $email_asli === '-' || !filter_var($email_asli, FILTER_VALIDATE_EMAIL)) {
                    $email = 'alumni_' . $nisn . '_' . rand(10, 99) . '@alumni.com';
                } else {
                    $email = $email_asli;
                }

                try {
                    $user = \App\Models\User::firstOrCreate(
                        ['email' => $email],
                        [
                            'name'     => $nama_lengkap,
                            'password' => bcrypt('password123'),
                            'role'     => 'alumni'
                        ]
                    );

                    \App\Models\Alumni::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'nisn'            => $nisn,
                            'tahun_lulus'     => $tahun_lulus,
                            'no_hp_wa'        => $no_hp,
                            'is_subscribe_wa' => true,
                            'status_akun'     => 'approved',
                            'kategori_id'     => 1, // Default Kompetensi Keahlian
                        ]
                    );

                    $berhasil++;
                } catch (\Exception $e) {
                    continue; // Jika ada baris yang cacat, lewati dan lanjut ke baris berikutnya
                }
            }
            fclose($handle);
            @unlink($path_aman);
        }

        if ($berhasil == 0) {
            return redirect()->back()->with('error', 'Sistem gagal membaca baris data. Pastikan format CSV sudah benar.');
        }

        return redirect()->back()->with('success', "Hebat! $berhasil data alumni berhasil diimpor menggunakan fitur Pencarian Kolom Otomatis.");
    }
}
