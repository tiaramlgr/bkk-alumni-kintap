<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $table = 'lamarans';

    protected $fillable = [
        'alumni_id',
        'lowongan_id',
        'file_cv',
        'surat_lamaran',
        'status_lamaran',
        'catatan_admin', 
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumni_id');
    }

    public function lowongan()
    {
        return $this->belongsTo(LowonganKerja::class, 'lowongan_id');
    }
}