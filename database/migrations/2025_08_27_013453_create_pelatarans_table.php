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
        Schema::create('pelatarans', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('nomor_pelataran');
            $table->string('ukuran_pelataran')->nullable();
            $table->decimal('harga_sewa', 12, 2)->nullable();
            $table->enum('satuan_retribusi', ['hari', 'bulan'])->default('hari');
            $table->enum('kategori_pelataran', ['tetap', 'tidaktetap', 'insidentil'])->default('tetap');
            $table->string('lokasi_pelataran')->nullable();
            $table->unsignedBigInteger('pasar_id'); // relasi manual ke pasar

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatarans');
    }
};