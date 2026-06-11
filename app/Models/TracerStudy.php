<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TracerStudy extends Model
{
    use HasFactory;

    protected $table = 'tracer_studies';

    // WAJIB: Pastikan semua kolom ini sama persis dengan yang ada di database Anda
    protected $fillable = [
        'alumni_id',
        'tahun_pengisian',
        'status_aktivitas',
        'nama_instansi',
        'jabatan',
        'kota_kerja',
        'masa_tunggu_bulan',
        'keselarasan_kerja',
        'pendapatan_ump',
        'nama_produk_usaha',
        'bidang_usaha',
        'kota_usaha',
        'keselarasan_usaha',
        'keterangan_status',
        'negara_kerja',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumni_id');
    }
}