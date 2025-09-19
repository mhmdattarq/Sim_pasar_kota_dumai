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
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nik'); // snapshot
            $table->string('nama');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('no_telp')->nullable();
            $table->text('alamat')->nullable();

            // Relasi ke pasar
            $table->foreignId('pasar_id')->constrained('pasar')->onDelete('cascade');
            $table->string('tipe_tempat')->nullable(); // los/kios/pelataran
            $table->string('nomor_tempat')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('luas')->nullable();
            $table->string('jenis_dagangan')->nullable();
            $table->time('jam_buka')->nullable();
            $table->time('jam_tutup')->nullable();

            $table->string('nib')->nullable();
            $table->string('npwp')->nullable();
            $table->string('ktp')->nullable();
            $table->string('kk')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['draft', 'lengkap', 'disetujui', 'ditolak'])->default('draft');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohon');
    }
};