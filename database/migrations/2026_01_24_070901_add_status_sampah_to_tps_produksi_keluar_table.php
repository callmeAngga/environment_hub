<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusSampahToTpsProduksiKeluarTable extends Migration
{
    public function up()
    {
        Schema::table('tps_produksi_keluar', function (Blueprint $table) {
            $table->unsignedBigInteger('status_sampah_id')
                ->after('total_unit');

            $table->foreign('status_sampah_id')
                ->references('id')
                ->on('status_sampah')
                ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::table('tps_produksi_keluar', function (Blueprint $table) {
            $table->dropForeign(['status_sampah_id']);
            $table->dropColumn('status_sampah_id');
        });
    }
}
