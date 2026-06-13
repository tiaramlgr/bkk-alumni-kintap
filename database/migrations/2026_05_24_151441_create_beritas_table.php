<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            // admin_id untuk mencatat siapa yang memposting
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->string('judul');
            $table->string('slug')->unique(); // Untuk URL SEO
            $table->text('konten');
            $table->string('foto')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('beritas');
    }
};