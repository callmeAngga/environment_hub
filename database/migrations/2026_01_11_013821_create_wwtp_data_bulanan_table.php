<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWwtpDataBulananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wwtp_data_bulanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wwtp_id')->constrained('lokasi_wwtp')->onDelete('cascade');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->decimal('tss_inlet', 10, 2)->nullable();
            $table->decimal('tss_outlet', 10, 2)->nullable();
            $table->decimal('tds_inlet', 10, 2)->nullable();
            $table->decimal('tds_outlet', 10, 2)->nullable();
            $table->decimal('bod_inlet', 10, 2)->nullable();
            $table->decimal('bod_outlet', 10, 2)->nullable();
            $table->decimal('cod_inlet', 10, 2)->nullable();
            $table->decimal('cod_outlet', 10, 2)->nullable();
            $table->decimal('minyak_lemak_inlet', 10, 2)->nullable();
            $table->decimal('minyak_lemak_outlet', 10, 2)->nullable();
            $table->timestamps();
            
            $table->index(['bulan', 'tahun', 'wwtp_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wwtp_data_bulanan');
    }
}
