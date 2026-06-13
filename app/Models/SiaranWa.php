<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiaranWa extends Model
{
    use HasFactory;

    protected $table = 'siaran_was';

    protected $fillable = [
        'admin_id',
        'judul_siaran',
        'jenis_siaran',
        'referensi_id',
        'referensi_type',
        'template_pesan',
        'total_penerima',
        'berhasil',
        'gagal',
        'status_batch',
        'dikirim_at',
        'meta',
    ];

    protected $casts = [
        'dikirim_at' => 'datetime',
        'meta'       => 'array', // otomatis encode/decode JSON, tidak perlu json_encode manual
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}