<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class TotalNetRecentHourly extends Model
{
    protected $table = 'total_net_hourly';

    protected $primaryKey = 'id';

    protected $dates = ['created_at'];
    
    public function totalNetRecent()
    {
    	return $this->belongsTo('App\Entities\TotalNetRecent', 'ItemID');
    }
}
