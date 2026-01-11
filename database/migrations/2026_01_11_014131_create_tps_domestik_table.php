<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpsDomestikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tps_domestik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tps_id')->constrained('tps')->cascadeOnDelete();
            $table->string('no_sampah_keluar', 50)->unique();
            $table->date('tanggal_pengangkutan');
            $table->foreignId('ekspedisi_id')->constrained('ekspedisi');
            $table->string('no_kendaraan', 20);
            $table->decimal('berat_bersih_kg', 10, 2);
            $table->foreignId('jenis_sampah_id')->constrained('jenis_sampah');
            $table->foreignId('penerima_id')->constrained('penerima');
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
        Schema::dropIfExists('tps_domestik');
    }
}
