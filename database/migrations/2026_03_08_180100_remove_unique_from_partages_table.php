<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partages', function (Blueprint $table) {
            $table->dropForeign(['favori_id']);
            $table->dropForeign(['ami_id']);
            $table->dropUnique(['favori_id', 'ami_id']);
            $table->foreign('favori_id')->references('id')->on('favoris')->onDelete('cascade');
            $table->foreign('ami_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('partages', function (Blueprint $table) {
            $table->dropForeign(['favori_id']);
            $table->dropForeign(['ami_id']);
            $table->unique(['favori_id', 'ami_id']);
            $table->foreign('favori_id')->references('id')->on('favoris')->onDelete('cascade');
            $table->foreign('ami_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
