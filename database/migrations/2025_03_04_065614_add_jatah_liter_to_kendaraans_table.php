<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Kendaraan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kendaraans', function (Blueprint $table) {
            $table->integer('jatah_liter_per_hari')->default(1)->after('jenis');
        });

        // Perbarui data kendaraan berdasarkan jenisnya
        foreach (Kendaraan::all() as $kendaraan) {
            $kendaraan->update([
                'jatah_liter_per_hari' => $kendaraan->jenis_kendaraan === 'roda_4' ? 7 : 1
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kendaraans', function (Blueprint $table) {
            $table->dropColumn('jatah_liter_per_hari');
        });
    }
};
