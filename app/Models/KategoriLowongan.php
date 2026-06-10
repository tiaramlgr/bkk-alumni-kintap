<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriLowongan extends Model
{
    use HasFactory;

    protected $table = 'kategori_lowongans';

    protected $fillable = ['nama_kategori', 'icon'];

    public function lowongans()
    {
        return $this->hasMany(LowonganKerja::class, 'kategori_id');
    }
}