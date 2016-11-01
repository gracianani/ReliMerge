<?php 

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Subline extends Model
{
	protected $table = 'display.station2ndRecent';

	protected $primaryKey = 'ItemID';

	public $timestamps = false;

	public function station()
	{
		return $this->belongsTo('App\Entities\Station', 'station_id');
	}

	public function TemperatureAutoControlLineOne()
    {
        return $this->hasOne('App\Entities\StationAutoControl')->wherePivot('GroupNo', 1);
    }

    public function TemperatureAutoControlLineTwo()
    {
        return $this->hasOne('App\Entities\StationAutoControl')->wherePivot('GroupNo', 2);
    }

    public function TimeAutoControlLineOne()
    {
        return $this->hasOne('App\Entities\StationAutoControl')->wherePivot('GroupNo', 1);
    }

    public function TimeAutoControlLineTwo()
    {
        return $this->hasOne('App\Entities\StationAutoControl')->wherePivot('GroupNo', 2);
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
			'water_flow' => $this->water_flow,
			'heat' => $this->heat,
			'control_mode' => $this->control_mode
		);
	}

}


