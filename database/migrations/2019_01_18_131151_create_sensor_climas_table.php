<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorClimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_climas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sensor_id');
            $table->datetime('data');
            $table->string('precipitacao');
            $table->string('temperatura');
            $table->string('umidadeDoAr');
            $table->string('vento');
            $table->string('radiacao');
            $table->string('pressao');
            $table->string('insolacao');
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
        Schema::dropIfExists('sensor_climas');
    }
}
