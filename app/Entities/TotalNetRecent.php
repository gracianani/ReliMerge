<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\ConstDefine;

class TotalNetRecent extends Model
{
    public $table = 'TotalNetRecent';

    public function heatRecentHourly()
    {
    	return $this->hasMany('App/Entities/TotalNetRecentHourly');
    }
}
