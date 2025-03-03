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
        Schema::create('penggunas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('nip', 50)->nullable();
            $table->foreignId('jabatan_id')->constrained('jabatans');
            $table->foreignId('bidang_id')->constrained('bidangs');
            $table->string('email', 100)->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggunas');
    }
};
