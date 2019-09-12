<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SensorClima extends Model
{
    protected $fillable = [
        'sensor_id', 'data', 'precipitacao', 'temperatura', 'umidadeDoAr', 'vento', 'radiacao', 'radiacao', 'pressao', 'insolacao'
    ];
}
