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
            $table->date('tanggal_beli'); // Menyesuaikan dengan model
            $table->integer('bulan'); // Tambahkan kolom bulan
            $table->integer('tahun'); // Tambahkan kolom tahun
            $table->decimal('jatah_liter_per_hari', 10, 2)->nullable(); // Tambahkan sesuai model
            $table->decimal('jatah_liter_per_bulan', 10, 2)->nullable(); // Tambahkan sesuai model
            $table->string('jenis_bbm'); // Tambahkan sesuai model
            $table->decimal('jumlah_liter', 10, 2)->nullable();
            $table->decimal('harga_per_liter', 10, 2)->nullable();
            $table->decimal('jumlah_harga', 15, 2); // Ubah dari total_biaya ke jumlah_harga agar sama dengan model
            $table->integer('kilometer_kendaraan')->nullable();
            $table->foreignId('pengeluaran_id')->nullable()->constrained('pengeluarans');
            $table->foreignId('pengguna_id')->nullable()->constrained('penggunas'); // Tambahkan kolom pengguna_id
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
