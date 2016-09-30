<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Station extends Model
{
    protected $table = 'Stations';

    protected $primaryKey = 'ItemID';

    public function company()
    {
    	return $this->belongsTo('App\Entities\Company');
    }

    public function stationAreas()
    {
    	return $this->hasMany('App\Entities\StationArea', '热力站ID');
    }

    public function getStationArrayAttribute()
    {
    	$area = $this->stationAreas->map(function($item, $key)
    	{
    		return $item->block_array;
    	});
    	return array(
    		'id' => $this->ItemID,
    		'station_num' => $this->station_num,
    		'name' => $this->name,
    		'company_id' => $this->company_id,
    		"company" => $this->company,
    		"subcompany_id" => $this->subcompany_id,
    		"address" => $this->address,
    		"main_line" => $this->main_line,
    		"sub_line" => $this->sub_line,
    		"is_water" => $this->is_water,
    		"is_whole" => $this->is_whole,
    		"is_important" => $this->is_important,
    		"gov_district" => $this->gov_district,
    		"prod_heatsource" => $this->prod_heatsource,
    		"prod_heatsource_id" => $this->prod_heatsource_id,
    		"datasource" => $this->datasource,
    		'revenual_type' => $this->revenual_type,
    		"area_a" => $this->area_a,
    		"area_b" => $this->area_b,
    		'area' => $area
    	);
    }


}
