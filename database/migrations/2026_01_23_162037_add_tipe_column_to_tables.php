<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipeColumnToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daftar_ekspedisi', function (Blueprint $table) {
            $table->string('tipe')->default('DOMESTIK')->after('alamat'); 
        });

        Schema::table('daftar_penerima', function (Blueprint $table) {
            $table->string('tipe')->default('DOMESTIK')->after('alamat');
        });

        Schema::table('tps', function (Blueprint $table) {
            $table->string('tipe')->default('DOMESTIK')->after('kapasitas_max');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daftar_ekspedisi', function (Blueprint $table) {
            $table->dropColumn('tipe');
        });

        Schema::table('daftar_penerima', function (Blueprint $table) {
            $table->dropColumn('tipe');
        });

        Schema::table('tps', function (Blueprint $table) {
            $table->dropColumn('tipe');
        });
    }
}