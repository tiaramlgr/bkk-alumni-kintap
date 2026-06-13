<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    // WAJIB ADA INI:
    protected $fillable = [
        'admin_id', 
        'judul', 
        'slug', 
        'konten', 
        'foto', 
        'status'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}