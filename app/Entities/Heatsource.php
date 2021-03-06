<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Heatsource extends Model
{
    protected $table = 'display.heatsources';

    protected $primaryKey = 'ItemID';

    protected $fillable = [ "heat_source_num", 'address','year_of_built', "district",
        "area", "name", "admin", "phone", "type", "is_gas", "inner_or_outer", 
        "is_whole", "heat_capacity", "max_hourly_heat_capacity", "max_daily_heat_capacity",
        "max_day_hourly_heat_capacity", "water_cycle", "max_water_cycle","additional_water",
        "max_inst_additional_water", "max_daily_additional_water", "max_monthly_additional_water",
        "daily_gas_usage", "hourly_gas_usage", "num_of_ovens", "oven_heat_capacity"
    ];

    protected $cast = [
        "area" => 'float',
        "is_whole" => 'boolean',
        "num_of_ovens" => 'float'
     ];

    public $timestamps = false;

    public function company()
    {
    	return $this->belongsTo('App\Entities\Company');
    }

    public function sublines()
    {
    	return $this->hasMany('App\Entities\HeatSourceRecents');
    }

    public function getSublineNameAttribute()
    {
        return $this->water_line + $this->gas_line;
    }

    public function getHeatSourceArrayAttribute()
    {
    	return array(
    		'id' => $this->ItemID,
    		'heat_source_num' => $this->heat_source_num,
    		'name' => $this->name,
    		'address' => $this->address,
    		"year_of_built" => $this->year_of_built,
    		"area" => $this->area,
    		"admin" => $this->admin,
    		"phone" => $this->phone,
    		"type" => $this->type,
    		"is_gas" => $this->is_gas,
    		"inner_or_outer" => $this->inner_or_outer ,
    		"district" => $this->district,
    		"is_whole" => $this->is_whole,
    		"subline_id" => 1,
    		"subline_name" => $this->subline_name,
    		"heat_capacity" => $this->heat_capacity,
    		"max_hourly_heat_capacity" => $this->max_hourly_heat_capacity,
    		"max_daily_heat_capacity" => $this->max_daily_heat_capacity,
    		"max_day_hourly_heat_capacity" => $this->max_day_hourly_heat_capacity,
    		"water_cycle" => $this->water_cycle,
    		"max_water_cycle" => $this->max_water_cycle,
    		"additional_water" => $this->additional_water,
    		"max_inst_additional_water" => $this->max_inst_additional_water,
    		"max_daily_additional_water" => $this->max_daily_additional_water,
    		"max_monthly_additional_water" => $this->max_monthly_additional_water,
    		"daily_gas_usage" => $this->daily_gas_usage,
    		"hourly_gas_usage" => $this->hourly_gas_usage,
    		"num_of_ovens" => (int)$this->num_of_ovens,
    		"oven_heat_capacity" => $this->oven_heat_capacity
    	);
    }

}
