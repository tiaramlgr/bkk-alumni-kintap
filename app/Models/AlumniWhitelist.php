<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniWhitelist extends Model
{
    use HasFactory;

    protected $table = 'alumni_whitelists';

    protected $fillable = [
        'nisn',
        'nama_lengkap',
        'tahun_lulus',
        'jurusan',
        'sudah_daftar',
        'keterangan',
    ];

    protected $casts = [
        'sudah_daftar' => 'boolean',
    ];

    public static function isValid(string $nisn): bool
    {
        return self::where('nisn', $nisn)
            ->where('sudah_daftar', false)
            ->exists();
    }

    public static function tandaiSudahDaftar(string $nisn): void
    {
        self::where('nisn', $nisn)->update(['sudah_daftar' => true]);
    }
}