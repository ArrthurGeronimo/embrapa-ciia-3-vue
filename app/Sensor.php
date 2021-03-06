<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $fillable = [
        'nome', 'marca', 'modelo', 'dataFabricacao', 'dataInstalacao', 'unidade'
    ];
}
