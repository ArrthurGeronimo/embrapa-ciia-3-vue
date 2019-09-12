<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperimentoFaixasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experimento_faixas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('experimento_id');
            $table->integer('quantidadeTratamentos');
            $table->integer('quantidadeRepeticoes');
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
        Schema::dropIfExists('experimento_faixas');
    }
}
