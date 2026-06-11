<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenAlumni extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumni_id',
        'admin_id',
        'tipe_dokumen',
        'nama_file',
        'path_file',
        'tahun_dokumen',
        'is_active', // Ini untuk Admin
        'status_verifikasi', // Baru: 'pending', 'approved', 'rejected'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function alumni() { return $this->belongsTo(Alumni::class); }
    public function admin() { return $this->belongsTo(User::class, 'admin_id'); }
}