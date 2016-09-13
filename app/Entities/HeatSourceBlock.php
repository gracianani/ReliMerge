<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class HeatSourceBlock extends Model
{
    public $timestamps = false;

    public $table = 'heatsource_blocks';
	
	public function block()
	{
		return $this->belongsTo('App\Entities\Block');
	}

	public function getHeatsourcesAttribute()
	{
		return HeatSource::all();
	}

    public function getBlockArrayAttribute()
    {
    	$multiplied = $this->heatsources->map(function ($item, $key) {
		    return $item->heat_source_array;
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
