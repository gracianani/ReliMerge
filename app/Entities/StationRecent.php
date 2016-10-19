<?php 

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class StationRecent extends Model
{
	protected $table = 'Station2ndRecent';

	protected $primaryKey = 'ItemID';

	public $timestamps = false;

	public function station()
	{
		return $this->belongsTo('App\Entities\Station', 'station_id');
	}

	public function getBlockArrayAttribute()
	{
		return array(
			'id' => $this->ItemID,
			'subline_name' => $this->subline_name,
			'subline_num' => $this->subline_num,
			'second_temperature_out' => $this->second_temperature_out,
			'second_temperature_in' => $this->second_temperature_in,
			'second_pressure_out' => $this->second_pressure_out,
			'second_pressure_in' => $this->second_pressure_in,
			'water_flow_inst' => $this->water_flow_inst,
			'heat_inst' => $this->heat_inst,
			'heat' => $this->heat,
			'control_mode' => $this->control_mode
		);
	}

}


