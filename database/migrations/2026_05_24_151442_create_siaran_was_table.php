<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('siaran_was', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users');
            
            $table->string('judul_siaran');
            $table->enum('jenis_siaran', ['lowongan', 'berita', 'pengumuman', 'lainnya']);
            $table->morphs('referensi'); // untuk lowongan atau berita
            $table->text('template_pesan');
            $table->integer('total_penerima')->default(0);
            $table->integer('berhasil')->default(0);
            $table->integer('gagal')->default(0);
            $table->enum('status_batch', ['pending', 'proses', 'selesai', 'gagal'])->default('pending');
            $table->timestamp('dikirim_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('siaran_was');
    }
};