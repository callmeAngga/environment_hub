<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKeteranganToTpsProduksiKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tps_produksi_keluar', function (Blueprint $table) {
            $table->text('keterangan')->nullable()->after('status_sampah_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tps_produksi_keluar', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }
}
