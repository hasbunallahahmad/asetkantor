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
        Schema::create('pembelian_bensins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->constrained('kendaraans');
            $table->date('tanggal_beli');
            $table->decimal('jumlah_liter', 10, 2)->nullable();
            $table->decimal('harga_per_liter', 10, 2)->nullable();
            $table->decimal('total_biaya', 15, 2);
            $table->integer('kilometer_kendaraan')->nullable();
            $table->foreignId('pengeluaran_id')->nullable()->constrained('pengeluarans');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_bensins');
    }
};
