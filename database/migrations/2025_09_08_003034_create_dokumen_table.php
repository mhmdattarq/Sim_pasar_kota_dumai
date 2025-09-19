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
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedagang_id'); // relasi ke pedagang
            $table->string('nama_file'); // nama asli file
            $table->string('path_file'); // path penyimpanan
            $table->timestamps();

            // Foreign key ke tabel pedagangregister
            $table->foreign('pedagang_id')
                ->references('id')
                ->on('pedagangregister')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};