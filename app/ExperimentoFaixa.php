<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperimentoFaixa extends Model
{
    protected $fillable = [
        'experimento_id', 'quantidadeTratamentos', 'quantidadeRepeticoes'
    ];
}
