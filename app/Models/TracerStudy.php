<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TracerStudy extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumni_id',
        'tahun_pengisian',
        'status_aktivitas',
        'keterangan_status',
        'masa_tunggu_bulan',
        'jabatan',
        'nama_instansi',
        'kota_kerja',
        'negara_kerja',
        'keselarasan_kerja',
        'bidang_usaha',
        'kota_usaha',
        'keselarasan_usaha',
        'nama_produk_usaha',
        'pendapatan_ump',
        'pendapatan_umk',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}