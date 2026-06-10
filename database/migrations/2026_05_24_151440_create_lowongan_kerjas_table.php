<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lowongan_kerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users');
            $table->foreignId('kategori_id')->nullable()->constrained('kategori_lowongans');
            
            $table->string('judul_lowongan');
            $table->string('nama_perusahaan');
            $table->string('lokasi');
            $table->string('tipe_pekerjaan')->default('full_time');
            $table->text('deskripsi');
            $table->text('kualifikasi');
            $table->date('deadline')->nullable();
            $table->enum('status', ['aktif', 'tutup', 'draft'])->default('aktif');
            $table->boolean('siaran_wa')->default(false);
            
            // INI YANG SEBELUMNYA KURANG:
            $table->string('foto')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lowongan_kerjas');
    }
};