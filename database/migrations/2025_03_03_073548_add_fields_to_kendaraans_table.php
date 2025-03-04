<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kendaraans', function (Blueprint $table) {
            $table->string('jenis')->nullable()->after('jenis_kendaraan_id');
            $table->integer('tahun')->nullable()->after('tahun_pengadaan');
            $table->string('pemegang')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('kendaraans', function (Blueprint $table) {
            $table->dropColumn(['jenis', 'tahun', 'pemegang']);
        });
    }
};
