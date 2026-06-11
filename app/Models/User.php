<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'is_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function alumni()
    {
        return $this->hasOne(Alumni::class, 'user_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'user_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function otpVerifikasis()
    {
        return $this->hasMany(OtpVerifikasi::class);
    }

    // Helper Method Sinkronisasi Hak Akses Router
    public function isAdmin()       { return $this->role === 'admin'; }
    public function isAlumni()      { return $this->role === 'alumni'; }
    public function isSiswa()       { return $this->role === 'siswa'; }
    public function isPerusahaan()  { return $this->role === 'perusahaan'; }
}