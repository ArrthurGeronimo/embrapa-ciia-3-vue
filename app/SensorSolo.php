<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SensorSolo extends Model
{
    protected $fillable = [
        'sensor_id', 'data', 'latitude', 'longitude', 'temperatura', 'umidade'
    ];
}
