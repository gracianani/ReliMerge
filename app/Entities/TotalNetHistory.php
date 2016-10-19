<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\ConstDefine;
use Carbon\Carbon;

class TotalNetHistory extends Model
{
    public $table = 'TotalNetHistory';

    public function getDistrictNameAttribute()
    {
    	switch ($this->ItemID)
    	{
    		case ConstDefine::EAST:
    			return ConstDefine::EAST_NAME;
    		case ConstDefine::WEST:
    			return ConstDefine::WEST_NAME;
    		case ConstDefine::TOTAL:
    			return ConstDefine::TOTAL_NAME;
    	}
    }

    public function temperature()
    {
        return $this->hasOne('App\Entities\Weather4','date', 'date');
    }

    public function getTemperatureActualAttribute()
    {
        if($this->temperature) {
            return $this->temperature->temperature_actual;
        }
    	return null;
    }

    public function getTemperaturePerdictAttribute()
    {
        if($this->temperature) {
    	   return $this->temperature->temperature_perdict;
        }
        return null;
    }

    public function getHeatPerSquareRefAttribute()
    {
    	return $this->heat_per_square * 17.4 / (18 - $this->temperature_perdict);
    }

    public function getTimestampAttribute()
    {
        return Carbon::createFromFormat("Y-m-d", $this->date)->timestamp;
    }

    public function getTitleAttribute()
    {
        return $this->district_name;
    }

	public function getBlockArrayAttribute()
    {
        return array(
            'id' => $this->ItemID,
            'district_name' => $this->district_name,
            'date' => $this->date,
            'area' => $this->area,
            'heat_per_square' => $this->heat_per_square,
            'heat_per_square_ref' => $this->heat_per_square_ref,
            'heat_index_actual' => $this->heat_index_actual,
            'heat_index_ref' => $this->heat_index_ref,
            'heat_actual' => $this->heat_actual,
            'heat_ref' => $this->heat_ref,
            'temperature_perdict' => $this->temperature_perdict,
            'temperature_actual' =>  $this->temperature_actual,

        );
    }
   
}
