<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tracer_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('alumnis')->onDelete('cascade');
            
            $table->integer('tahun_pengisian');
            $table->enum('status_aktivitas', ['bekerja', 'wirausaha', 'kuliah', 'menganggur', 'lainnya']);
            $table->string('keterangan_status')->nullable();
            $table->integer('masa_tunggu_bulan')->nullable();
            
            // Pekerjaan
            $table->string('jabatan')->nullable();
            $table->string('nama_instansi')->nullable();
            $table->string('kota_kerja')->nullable();
            $table->string('negara_kerja')->default('Indonesia');
            $table->enum('keselarasan_kerja', ['sangat_tinggi', 'tinggi', 'sedang', 'rendah'])->nullable();
            
            // Wirausaha
            $table->string('bidang_usaha')->nullable();
            $table->string('kota_usaha')->nullable();
            $table->enum('keselarasan_usaha', ['sangat_tinggi', 'tinggi', 'sedang', 'rendah'])->nullable();
            $table->string('nama_produk_usaha')->nullable();
            
            // Pendapatan
            $table->enum('pendapatan_ump', ['di_bawah_ump', 'setara_ump', 'di_atas_ump'])->nullable();
            $table->enum('pendapatan_umk', ['di_bawah_umk', 'setara_umk', 'di_atas_umk'])->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tracer_studies');
    }
};