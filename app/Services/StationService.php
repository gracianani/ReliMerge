<?php namespace App\Services;

use App\Entities\Station;
use App\Entities\StationRecent;

class StationService
{
	public function fetchAll()
	{
		return Station::all();
	}

	public function fetAllRealtime($value='')
	{
		return StationRecent::all();
	}

	public function fetch($id)
	{
		return Station::find($id);
	}
}