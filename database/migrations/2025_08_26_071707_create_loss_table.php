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
        Schema::create('loss', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('nomor_los');
            $table->string('ukuran_los')->nullable();
            $table->decimal('harga_sewa', 12, 2)->nullable();
            $table->enum('status_los', ['tersedia', 'terisi', 'pengajuan'])->default('tersedia');
            $table->string('lokasi_los')->nullable();
            $table->unsignedBigInteger('pasar_id'); // relasi manual ke pasar

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loss');
    }
};