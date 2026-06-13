<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kompetensi',
        'nama_program',
        'nama_bidang',
        'kode_jurusan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function alumnis()
    {
        return $this->hasMany(Alumni::class);
    }
}