<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\ConstDefine;

class Weather4 extends Model
{
    public $table = 'display.Weather4';

    protected $primaryKey = 'ItemID';

    protected $casts = [
        "temperature_perdict" => 'float',
        "temperature_actual" => 'float', 
        'heat_index_planned' => 'float',
    ];
}
