<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lamarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('alumnis')->onDelete('cascade');
            $table->foreignId('lowongan_id')->constrained('lowongan_kerjas')->onDelete('cascade');
            
            $table->string('file_cv')->nullable();
            $table->text('surat_lamaran')->nullable();
            $table->enum('status_lamaran', ['pending', 'diterima', 'ditolak', 'dibatalkan'])->default('pending');
            $table->text('catatan_admin')->nullable();
            
            $table->timestamps();
            
            // Unique agar tidak bisa melamar 2x di lowongan yang sama
            $table->unique(['alumni_id', 'lowongan_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('lamarans');
    }
};