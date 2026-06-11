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
        'template_pesan',
        'total_penerima',
        'status_batch',
        'meta',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}