<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('log_siaran_was', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siaran_id')->constrained('siaran_was')->onDelete('cascade');
            $table->foreignId('alumni_id')->nullable()->constrained('alumnis');
            
            $table->string('no_tujuan');
            $table->enum('status_kirim', ['pending', 'sent', 'delivered', 'failed', 'read']);
            $table->string('message_id_api')->nullable();
            $table->timestamp('sent_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_siaran_was');
    }
};