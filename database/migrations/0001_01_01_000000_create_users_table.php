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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // admin login dengan username
            $table->string('username')->nullable()->unique();

            // pedagang login dengan NIK
            $table->string('nik')->nullable()->unique();

            $table->string('password')->nullable();
            $table->enum('role', ['admin', 'pedagang']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
