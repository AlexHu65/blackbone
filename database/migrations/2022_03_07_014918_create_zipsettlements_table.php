<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZipsettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zipsettlements', function (Blueprint $table) {
            $table->id('key');
            $table->string('name');
            $table->string('zone_type');
            $table->string('settlement_type');
            $table->integer('id_federal_entity');
            $table->integer('id_municipality');
            $table->integer('id_asenta_cpcons');
            $table->integer('id_settlement_type');
            $table->string('codigo');
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
        Schema::dropIfExists('zipsettlements');
    }
}
