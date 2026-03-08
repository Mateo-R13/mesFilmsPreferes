<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favoris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('tmdb_id');
            $table->string('titre');
            $table->text('synopsis')->nullable();
            $table->string('affiche')->nullable();
            $table->string('annee')->nullable();
            $table->decimal('note_tmdb', 3, 1)->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'tmdb_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favoris');
    }
};
