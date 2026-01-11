<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWwtpDataHarianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wwtp_data_harian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wwtp_id')->constrained('lokasi_wwtp')->onDelete('cascade');
            $table->foreignId('operator_id')->constrained('operator_wwtp')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('waktu');
            $table->decimal('debit_inlet', 10, 2)->nullable();
            $table->decimal('debit_outlet', 10, 2)->nullable();
            $table->decimal('ph_ekualisasi_1', 4, 1)->nullable();
            $table->decimal('ph_ekualisasi_2', 4, 1)->nullable();
            $table->decimal('suhu_ekualisasi_1', 4, 1)->nullable();
            $table->decimal('suhu_ekualisasi_2', 4, 1)->nullable();
            $table->decimal('ph_aerasi_1', 4, 1)->nullable();
            $table->decimal('ph_aerasi_2', 4, 1)->nullable();
            $table->integer('sv30_aerasi_1')->nullable();
            $table->integer('sv30_aerasi_2')->nullable();
            $table->decimal('do_aerasi_1', 4, 3)->nullable();
            $table->decimal('do_aerasi_2', 4, 3)->nullable();
            $table->decimal('ph_outlet', 4, 1)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->index(['tanggal', 'wwtp_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wwtp_data_harian');
    }
}
