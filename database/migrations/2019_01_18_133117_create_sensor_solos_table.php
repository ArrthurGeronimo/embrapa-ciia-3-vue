<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorSolosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_solos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sensor_id');
            $table->datetime('data');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('temperatura');
            $table->string('umidade');
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
        Schema::dropIfExists('sensor_solos');
    }
}
