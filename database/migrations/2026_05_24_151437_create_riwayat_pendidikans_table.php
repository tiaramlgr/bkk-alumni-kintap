<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('riwayat_pendidikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('alumnis')->onDelete('cascade');
            
            $table->enum('jenjang', ['sma', 'd1', 'd2', 'd3', 'd4', 's1', 's2', 's3']);
            $table->string('nama_institusi');
            $table->string('nama_prodi')->nullable();
            $table->enum('keselarasan_studi', ['sangat_tinggi', 'tinggi', 'sedang', 'rendah'])->nullable();
            $table->integer('tahun_masuk')->nullable();
            $table->integer('tahun_lulus')->nullable();
            $table->enum('status_studi', ['lulus', 'masih_kuliah', 'dropout'])->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_pendidikans');
    }
};