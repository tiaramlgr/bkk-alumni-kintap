<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowonganKerja extends Model
{
    use HasFactory;

    protected $table = 'lowongan_kerjas';

    protected $fillable = [
        'admin_id',
        'kategori_id',
        'judul_lowongan',
        'nama_perusahaan',
        'lokasi',
        'tipe_pekerjaan',
        'deskripsi',
        'kualifikasi',
        'foto',
        'deadline',
        'status',
        'siaran_wa',
        'sektor_industri',
        'no_telepon',
    ];

    protected $casts = [
        'deadline' => 'date',
        'siaran_wa' => 'boolean',
    ];

    public function kategori()
    {
        // Daftarkan 'kategori_id' sebagai penghubung manual ke model induk
        return $this->belongsTo(KategoriLowongan::class, 'kategori_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class, 'lowongan_id');
    }
}