<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experimentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->default('Experimento Sem Nome');
            $table->string('categoria');
            $table->string('tipoDado');
            $table->string('estado')->default('Em preparação');
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
        Schema::dropIfExists('experimentos');
    }
}
