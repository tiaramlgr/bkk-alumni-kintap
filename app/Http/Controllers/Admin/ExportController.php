<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\TracerStudy;
use App\Models\LowonganKerja;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /* ------------------------------------------------------------------ */
    /*  EXPORT ALUMNI                                                       */
    /* ------------------------------------------------------------------ */
    public function alumni()
    {
        $alumnis = Alumni::with('user', 'jurusan')->get();

        $rows   = [];
        $rows[] = ['No', 'Nama Lengkap', 'NISN', 'Jurusan', 'Tahun Lulus',
                   'No HP/WA', 'Status Akun', 'Subscribe WA', 'Tanggal Daftar'];

        foreach ($alumnis as $i => $alumni) {
            $rows[] = [
                $i + 1,
                $alumni->user->name ?? '-',
                $alumni->nisn ?? '-',
                $alumni->jurusan->nama_jurusan ?? '-',
                $alumni->tahun_lulus ?? '-',
                $alumni->no_hp_wa ?? '-',
                $alumni->status_akun ?? '-',
                $alumni->is_subscribe_wa ? 'Ya' : 'Tidak',
                optional($alumni->created_at)->format('d/m/Y H:i') ?? '-',
            ];
        }

        return $this->streamCsv($rows, 'data_alumni_' . date('Ymd_His') . '.csv');
    }

    /* ------------------------------------------------------------------ */
    /*  EXPORT TRACER STUDY                                                 */
    /* ------------------------------------------------------------------ */
    public function tracerStudy()
    {
        $tracers = TracerStudy::with('alumni.user', 'alumni.jurusan')->get();

        $rows   = [];
        $rows[] = [
            'No', 'Nama Alumni', 'Jurusan', 'Tahun Lulus',
            'Tahun Pengisian', 'Status Aktivitas', 'Keterangan',
            'Masa Tunggu (Bulan)', 'Jabatan', 'Nama Instansi',
            'Kota Kerja', 'Keselarasan Kerja',
        ];

        foreach ($tracers as $i => $tracer) {
            $alumni = $tracer->alumni;
            $rows[] = [
                $i + 1,
                $alumni->user->name ?? '-',
                $alumni->jurusan->nama_jurusan ?? '-',
                $alumni->tahun_lulus ?? '-',
                $tracer->tahun_pengisian,
                $tracer->status_aktivitas,
                $tracer->keterangan_status ?? '-',
                $tracer->masa_tunggu_bulan ?? '-',
                $tracer->jabatan ?? '-',
                $tracer->nama_instansi ?? '-',
                $tracer->kota_kerja ?? '-',
                $tracer->keselarasan_kerja ?? '-',
            ];
        }

        return $this->streamCsv($rows, 'tracer_study_' . date('Ymd_His') . '.csv');
    }

    /* ------------------------------------------------------------------ */
    /*  EXPORT LOWONGAN                                                     */
    /* ------------------------------------------------------------------ */
    public function lowongan()
    {
        $lowongans = LowonganKerja::with('kategori')->get();

        $rows   = [];
        $rows[] = ['No', 'Judul', 'Perusahaan', 'Lokasi', 'Tipe', 'Kategori',
                   'Deadline', 'Status', 'Jumlah Lamaran'];

        foreach ($lowongans as $i => $lw) {
            $rows[] = [
                $i + 1,
                $lw->judul_lowongan,
                $lw->nama_perusahaan,
                $lw->lokasi,
                $lw->tipe_pekerjaan,
                $lw->kategori->nama_kategori ?? '-',
                optional($lw->deadline)->format('d/m/Y'),
                $lw->status,
                $lw->lamarans()->count(),
            ];
        }

        return $this->streamCsv($rows, 'data_lowongan_' . date('Ymd_His') . '.csv');
    }

    /* ------------------------------------------------------------------ */
    /*  PRIVATE HELPER                                                      */
    /* ------------------------------------------------------------------ */
    private function streamCsv(array $rows, string $filename)
    {
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // BOM untuk Excel agar bisa baca UTF-8
        $callback = function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}