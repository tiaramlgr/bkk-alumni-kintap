<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LowonganKerja extends Model
{
    protected $fillable = [
    'admin_id',
    'kategori_id',
    'judul_lowongan',
    'nama_perusahaan',
    'lokasi',
    'tipe_pekerjaan',
    'deskripsi',
    'kualifikasi',
    'deadline',
    'status',
    'siaran_wa',
    'foto',     
];
}