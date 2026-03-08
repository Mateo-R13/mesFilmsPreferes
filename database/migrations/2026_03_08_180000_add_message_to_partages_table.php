<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partages', function (Blueprint $table) {
            $table->string('message', 500)->nullable()->after('ami_id');
        });
    }

    public function down(): void
    {
        Schema::table('partages', function (Blueprint $table) {
            $table->dropColumn('message');
        });
    }
};
