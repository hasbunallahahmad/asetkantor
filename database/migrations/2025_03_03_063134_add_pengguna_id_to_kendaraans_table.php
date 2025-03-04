<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPenggunaIdToKendaraansTable extends Migration
{
    public function up()
    {
        Schema::table('kendaraans', function (Blueprint $table) {
            $table->foreignId('pengguna_id')->nullable()->constrained('penggunas')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('kendaraans', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            $table->dropColumn('pengguna_id');
        });
    }
}
