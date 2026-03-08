<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('favori_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('Celui qui partage');
            $table->foreignId('ami_id')->constrained('users')->onDelete('cascade')->comment('Celui qui reçoit');
            $table->timestamps();
            $table->unique(['favori_id', 'ami_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partages');
    }
};
