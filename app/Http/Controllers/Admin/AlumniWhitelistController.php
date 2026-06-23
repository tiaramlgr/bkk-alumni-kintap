<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniWhitelist;
use Illuminate\Http\Request;

class AlumniWhitelistController extends Controller
{
    public function index(Request $request)
    {
        $query = AlumniWhitelist::query();

        if ($request->filled('search')) {
            $cari = $request->search;
            $query->where(function ($q) use ($cari) {
                $q->where('nisn', 'like', "%{$cari}%")
                  ->orWhere('nama_lengkap', 'like', "%{$cari}%")
                  ->orWhere('jurusan', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('sudah_daftar', $request->status === 'sudah');
        }

        $whitelists = $query->orderBy('tahun_lulus', 'desc')->paginate(25)->withQueryString();

        return view('admin.whitelist.index', compact('whitelists'));
    }

    public function create()
    {
        return view('admin.whitelist.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn'         => 'required|string|max:20|unique:alumni_whitelists,nisn',
            'nama_lengkap' => 'nullable|string|max:255',
            'tahun_lulus'  => 'nullable|digits:4',
            'jurusan'      => 'nullable|string|max:255',
            'keterangan'   => 'nullable|string|max:500',
        ]);

        AlumniWhitelist::create([
            'nisn'         => trim($request->nisn),
            'nama_lengkap' => $request->nama_lengkap,
            'tahun_lulus'  => $request->tahun_lulus,
            'jurusan'      => $request->jurusan,
            'keterangan'   => $request->keterangan,
        ]);

        return redirect()->route('admin.whitelist.index')
            ->with('success', "NISN {$request->nisn} berhasil ditambahkan ke whitelist.");
    }

    public function destroy(AlumniWhitelist $whitelist)
    {
        if ($whitelist->sudah_daftar) {
            return back()->withErrors(['delete' => 'NISN ini sudah digunakan mendaftar, tidak dapat dihapus.']);
        }

        $whitelist->delete();

        return back()->with('success', "NISN {$whitelist->nisn} berhasil dihapus dari whitelist.");
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_csv' => 'required|file|max:2048',
        ]);

        $file = $request->file('file_csv');

        // Pastikan file benar-benar terupload dan path tersedia
        if (!$file || !$file->isValid()) {
            return back()->withErrors(['file_csv' => 'File gagal diupload. Coba lagi.']);
        }

        // Baca isi file langsung dari konten (lebih aman dari getRealPath)
        $konten = file_get_contents($file->getPathname());

        if (empty($konten)) {
            return back()->withErrors(['file_csv' => 'File CSV kosong atau tidak bisa dibaca.']);
        }

        // Pecah per baris
        $baris = array_filter(explode("\n", str_replace("\r\n", "\n", $konten)));
        $baris = array_values($baris);

        if (count($baris) <= 1) {
            return back()->withErrors(['file_csv' => 'File CSV tidak memiliki data (hanya header).']);
        }

        // Lewati baris pertama (header)
        array_shift($baris);

        $berhasil = 0;
        $duplikat = 0;
        $gagal    = 0;

        foreach ($baris as $b) {
            $kolom = str_getcsv($b);

            if (empty($kolom[0])) continue;

            $nisn = trim($kolom[0]);

            if (AlumniWhitelist::where('nisn', $nisn)->exists()) {
                $duplikat++;
                continue;
            }

            try {
                AlumniWhitelist::create([
                    'nisn'         => $nisn,
                    'nama_lengkap' => isset($kolom[1]) ? trim($kolom[1]) : null,
                    'tahun_lulus'  => isset($kolom[2]) ? trim($kolom[2]) : null,
                    'jurusan'      => isset($kolom[3]) ? trim($kolom[3]) : null,
                ]);
                $berhasil++;
            } catch (\Exception $e) {
                $gagal++;
            }
        }

        return back()->with('success',
            "Import selesai: {$berhasil} NISN ditambahkan, {$duplikat} duplikat dilewati, {$gagal} gagal."
        );
    }

    public function resetStatus(AlumniWhitelist $whitelist)
    {
        $whitelist->update(['sudah_daftar' => false]);

        return back()->with('success', "Status NISN {$whitelist->nisn} berhasil direset.");
    }
}