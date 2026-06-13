<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siaran_was', function (Blueprint $table) {
            // morphs() default membuat kolom NOT NULL -> gagal saat siaran manual
            // (controller tidak mengisi referensi_id/referensi_type)
            $table->unsignedBigInteger('referensi_id')->nullable()->change();
            $table->string('referensi_type')->nullable()->change();

            // dipakai controller untuk menyimpan ringkasan hasil kirim
            $table->json('meta')->nullable()->after('dikirim_at');
        });
    }

    public function down(): void
    {
        Schema::table('siaran_was', function (Blueprint $table) {
            $table->dropColumn('meta');
        });
    }
};