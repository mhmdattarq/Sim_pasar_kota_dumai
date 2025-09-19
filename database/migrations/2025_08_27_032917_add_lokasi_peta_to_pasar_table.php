<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pasar', function (Blueprint $table) {
            $table->text('lokasi_peta')->nullable(); // simpan embed google maps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasar', function (Blueprint $table) {
            $table->dropColumn('lokasi_peta');
        });
    }
};