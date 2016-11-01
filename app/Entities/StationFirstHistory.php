<?php 

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class StationFirstHistory extends Model
{
	protected $table = 'Station1stHistory';

	protected $primaryKey = 'ItemID';

	protected $timestamps = false;

	public function station()
	{
		return $this->belongsTo('App\Entities\Station');
	}

	public function getStationIdAttribute()
	{
		return $this->{'热力站ID'};
	}

	public function getDateAttribute()
	{
		return $this->{'时间'};
	}

	public function getFirstTemperatureOutAttribute()
	{
		return $this->{'一次供温'};
	}

	public function getFirstTemperatureInAttribute()
	{
		return $this->{'一次回温'};
	}

	public function getFirstPressureOutAttribute()
	{
		return $this->{'一次供压'};
	}

	public function getFirstPressureInAttribute()
	{
		return $this->{'一次回压'};
	}

	public function getTotalHeatAttribute()
	{
		return $this->{'总累计热量'};
	}

	public function getTotalWaterFlowAttribute()
	{
		return $this->{'总累计流量'};
	}

	public function getTotalWaterFlowInstAttribute()
	{
		return $this->{'总瞬时流量'};
	}

	public function getTotalHeatInstAttribute()
	{
		return $this->{'总瞬时热量'};
	}
	
	public function getHeatIndexActualAttribute()
	{
		return $this->{'实际热指标'};
	}

	public function getFlowTenThouAttribute()
	{
		return $this->{'万平方米流量'};
	}

	public function getWaterMeterAttribute()
	{
		return $this->{'水表'};
	}
}