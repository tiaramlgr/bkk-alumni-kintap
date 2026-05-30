<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('jurusan_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('nisn')->unique();
            $table->string('no_ijazah')->nullable();
            $table->string('no_skhu')->nullable();
            $table->string('tahun_lulus');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->enum('status_menikah', ['single', 'menikah', 'cerai'])->default('single');
            $table->text('alamat')->nullable();
            $table->string('provinsi_domisili')->nullable();
            $table->string('kota_domisili')->nullable();
            $table->string('no_hp_wa');
            $table->boolean('is_subscribe_wa')->default(true);
            $table->text('sertifikat_kompetensi')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status_akun', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan_verifikasi')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alumnis');
    }
};