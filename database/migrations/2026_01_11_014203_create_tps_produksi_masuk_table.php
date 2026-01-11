<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpsProduksiMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tps_produksi_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tps_id')->constrained('tps');
            $table->date('tanggal');
            $table->integer('jumlah_sampah');
            $table->foreignId('satuan_sampah_id')->constrained('satuan_sampah');
            $table->foreignId('jenis_sampah_id')->constrained('jenis_sampah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tps_produksi_masuk');
    }
}
