<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experimento extends Model
{
    protected $fillable = [
        'nome', 'categoria', 'tipoDado'
    ];
}
