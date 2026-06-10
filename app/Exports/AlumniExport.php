<?php

namespace App\Exports;

use App\Models\Alumni;
use Illuminate\Support\Collection;

class AlumniExport
{
    protected $alumnis;

    public function __construct($alumnis)
    {
        $this->alumnis = $alumnis;
    }

    public function collection()
    {
        return $this->alumnis;
    }

    public function headings(): array
    {
        return [
            'No', 'Nama', 'NISN', 'Jurusan', 'Tahun Lulus', 'No HP', 'Status Akun', 'Tanggal Daftar'
        ];
    }

    public function map($alumni): array
    {
        return [
            $alumni->id,
            $alumni->user->name ?? '-',
            $alumni->nisn,
            $alumni->jurusan->nama_jurusan ?? '-',
            $alumni->tahun_lulus,
            $alumni->no_hp_wa,
            $alumni->status_akun,
            $alumni->created_at->format('d/m/Y'),
        ];
    }
}