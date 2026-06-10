<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dokumen_alumnis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('alumnis')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('users');
            $table->enum('tipe_dokumen', ['skhu', 'ijazah', 'transkrip', 'sertifikat']);
            $table->string('nama_file');
            $table->string('path_file');
            $table->string('tahun_dokumen')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumen_alumnis');
    }
};