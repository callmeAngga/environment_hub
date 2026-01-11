<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLokasiWwtpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lokasi_wwtp', function (Blueprint $table) {
            $table->id();
            $table->string('nama_wwtp');
            $table->text('alamat');
            $table->decimal('koordinat_lat', 10, 8);
            $table->decimal('koordinat_lng', 11, 8);
            $table->decimal('kapasitas_debit', 10, 2);
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
        Schema::dropIfExists('lokasi_wwtp');
    }
}
