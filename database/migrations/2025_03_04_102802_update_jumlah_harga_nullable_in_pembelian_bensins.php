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
            $table->decimal('jumlah_harga', 15, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelian_bensins', function (Blueprint $table) {
            //
            $table->decimal('jumlah_harga', 15, 2)->change();
        });
    }
};
