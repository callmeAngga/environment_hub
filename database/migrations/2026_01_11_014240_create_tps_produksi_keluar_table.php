<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpsProduksiKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tps_produksi_keluar', function (Blueprint $table) {
    $table->id();
    

    $table->foreignId('tps_id')->constrained('tps');
    $table->date('tanggal_pengangkutan');
    $table->string('no_sampah_keluar', 50)->unique();
    $table->foreignId('ekspedisi_id')->constrained('daftar_ekspedisi'); 
    $table->string('no_kendaraan', 20);
    $table->decimal('berat_kosong_kg', 10, 2);
    $table->decimal('berat_isi_kg', 10, 2);
    $table->decimal('berat_bersih_kg', 10, 2)
          ->virtualAs('berat_isi_kg - berat_kosong_kg'); 
    $table->foreignId('jenis_sampah_id')->constrained('jenis_sampah');
    $table->foreignId('penerima_id')->constrained('daftar_penerima');
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
        Schema::dropIfExists('tps_produksi_keluar');
    }
}
