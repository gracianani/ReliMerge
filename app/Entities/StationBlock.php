<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use ReliStations;
use ReliTotalNet;

class StationBlock extends Model
{
    public $timestamps = false;

    public $table = 'station_blocks';
	
	public function block()
	{
		return $this->belongsTo('App\Entities\Block');
	}

	public function getStationsAttribute()
	{
		return ReliStations::fetchAll();
	}

	public function getStationRecentsAttribute()
	{
		return ReliStations::fetAllRealtime();
	}

	public function getBlockArrayAttribute()
    {
    	$multiplied = $this->stations->map(function ($item, $key) {
		    return $item->station_array;
		});

    	$header = $this->block->headerBlockUnits->map( function($item, $key) {
    		return $item->table_header_block_unit_array;
    	})->sortBy('sequence')->values();
        
    	return array(
    		"header" => $header,
    		"content" => $multiplied
    	);
    }

    public function getStationRecentBlockArrayAttribute()
    {

        $multiplied = $this->stations->map(function ($item, $key) {
            return $item->station_recent_array;
        });

        $header = $this->block->headerBlockUnits->map( function($item, $key) {
            return $item->table_header_block_unit_array;
        });
        
        return array(
            "header" => $header,
            "content" => $multiplied
        );
    }
}