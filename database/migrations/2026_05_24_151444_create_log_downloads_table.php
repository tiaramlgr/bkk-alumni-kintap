<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('log_downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokumen_id')->constrained('dokumen_alumnis')->onDelete('cascade');
            $table->foreignId('alumni_id')->constrained('alumnis');
            $table->string('ip_address');
            $table->timestamp('downloaded_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_downloads');
    }
};