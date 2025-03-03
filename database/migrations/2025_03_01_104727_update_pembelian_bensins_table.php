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
        Schema::table('pembelian_bensins', function (Blueprint $table) {
            //
            $table->dropForeign(['pengeluaran_id']);

            $table->dropColumn(['tanggal_beli', 'jumlah_liter', 'harga_per_liter', 'total_biaya', 'kilometer_kendaraan', 'pengeluaran_id']);

            $table->integer('bulan')->after('kendaraan_id');
            $table->integer('tahun')->after('bulan');
            $table->decimal('realisasi', 12, 2)->after('tahun');

            $table->text('keterangan')->nullable()->change();

            $table->unique(['kendaraan_id', 'bulan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelian_bensins', function (Blueprint $table) {
            //
            $table->date('tanggal_beli')->nullable();
            $table->decimal('jumlah_liter', 10, 2)->nullable();
            $table->decimal('harga_per_liter', 10, 2)->nullable();
            $table->decimal('total_biaya', 15, 2)->nullable();
            $table->integer('kilometer_kendaraan')->nullable();
            $table->foreignId('pengeluaran_id')->nullable()->constrained('pengeluarans');

            $table->dropColumn(['bulan', 'tahun', 'realisasi']);

            $table->dropUnique(['kendaraan_id', 'bulan', 'tahun']);
        });
    }
};
