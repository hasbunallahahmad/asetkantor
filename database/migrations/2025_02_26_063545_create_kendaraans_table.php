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
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('merk', 50);
            $table->string('model', 50);
            $table->string('plat_nomor', 20)->unique();
            $table->string('nomor_mesin', 50)->nullable();
            $table->string('nomor_rangka', 50)->nullable();
            $table->year('tahun_pengadaan');
            $table->foreignId('jenis_kendaraan_id')->constrained('jenis_kendaraans');
            $table->decimal('anggaran_tahunan', 15, 2);
            $table->date('tanggal_pajak_tahunan')->nullable();
            $table->date('tanggal_stnk_habis')->nullable();
            $table->enum('status', ['Aktif', 'Dalam Perbaikan', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
