<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class StationAccumulate extends Model
{
    protected $table = 'StationAccuHistory';

    protected $primaryKey = 'ItemID';

    public function getDateAttribute()
    {
    	return $this->{'日期'};
    }

    public function getStationIdAttribute()
    {
    	return $this->{'热力站ID'};
    }

    public function getAreaInUseAttribute()
    {
    	return $this->{'投入面积'};
    }
}
