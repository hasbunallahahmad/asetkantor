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
        Schema::create('servis_kendaraans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->constrained('kendaraans');
            $table->date('tanggal_servis');
            $table->string('jenis_servis', 100);
            $table->integer('kilometer_kendaraan')->nullable();
            $table->string('bengkel', 100)->nullable();
            $table->decimal('biaya', 15, 2);
            $table->text('keterangan')->nullable();
            $table->foreignId('pengeluaran_id')->nullable()->constrained('pengeluarans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servis_kendaraans');
    }
};
