<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel ini menyimpan daftar NISN resmi alumni SMKN Kintap.
     * Hanya NISN yang terdaftar di sini yang boleh mendaftar ke portal alumni.
     * Admin dapat mengimpor data ini dari arsip sekolah.
     */
    public function up(): void
    {
        Schema::create('alumni_whitelists', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 20)->unique()->comment('NISN resmi dari data sekolah');
            $table->string('nama_lengkap')->nullable()->comment('Nama asli dari arsip sekolah (opsional, untuk cross-check)');
            $table->string('tahun_lulus', 4)->nullable()->comment('Tahun lulus sesuai arsip sekolah');
            $table->string('jurusan')->nullable()->comment('Jurusan/kompetensi keahlian');
            $table->boolean('sudah_daftar')->default(false)->comment('Tandai jika NISN ini sudah dipakai mendaftar');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_whitelists');
    }
};