<?php 

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class StationAutoControl extends Model
{
	protected $table = 'station_auto_control_2';

	protected $primaryKey = 'AutoId';

	protected $timestamps = false;

	public function station()
	{
		return $this->belongsTo('App\Entities\Station');
	}

	public function getStationIdAttribute()
	{
		return $this->{'热力站ID'};
	}

	public function getSublineNumAttribute()
	{
		return $this->{'机组号'};
	}
}