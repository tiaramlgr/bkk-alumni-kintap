<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jurusan_id',
        'nisn',
        'no_ijazah',
        'no_skhu',
        'tahun_lulus',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'status_menikah',
        'alamat',
        'provinsi_domisili',
        'kota_domisili',
        'no_hp_wa',
        'status_akun',
        'is_subscribe_wa',
        'sertifikat_kompetensi',
        'foto',
        'status_akun',
        'catatan_verifikasi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'is_subscribe_wa' => 'boolean',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function tracerStudy()
    {
        return $this->hasOne(TracerStudy::class);
    }

    public function dokumens()
    {
        return $this->hasMany(DokumenAlumni::class);
    }

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class);
    }
}