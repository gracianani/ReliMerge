<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\ConstDefine;

class TotalNetRecent extends Model
{
    public $table = 'TotalNetRecent';

    protected $primaryKey = 'ItemID';

    public function totalNetRecentHourly()
    {
    	return $this->hasMany('App\Entities\TotalNetRecentHourly', 'total_net_recent_id', 'ItemID');
    }
}
