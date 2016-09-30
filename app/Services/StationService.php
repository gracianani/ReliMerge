<?php namespace App\Services;

use App\Entities\Station;

class StationService
{
	public function fetchAll()
	{
		return Station::all();
	}
}