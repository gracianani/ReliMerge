<?php 

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ControlChangeLog extends Model
{
	protected $table = 'ControlChangeLog';

	protected $primaryKey = 'ItemId';

	public $timestamps = false;

	public function setStationIdAttribute($value)
	{
		$this->{'热力站ID'} = $value;
	}

	public function getStationIdAttribute()
	{
		return $this->{'热力站ID'};
	}

	public function setSublineNumAttribute($value)
	{
		$this->{'机组号'} = $value;
	}

	public function getSublineNumAttribute()
	{
		return $this->{'机组号'};
	}
 
}