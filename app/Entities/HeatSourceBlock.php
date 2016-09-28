<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use ReliHeatsources;
use ReliTotalNet;

class HeatSourceBlock extends Model
{
    public $timestamps = false;

    public $table = 'heatsource_blocks';
	
	public function block()
	{
		return $this->belongsTo('App\Entities\Block');
	}

    public function getHeatsourceRecentsAttribute()
    {
        return ReliHeatsources::fetchAllRealtime();
    }

    public function getHeatsourcesAttribute()
    {
        return ReliHeatsources::fetchAll();
    }

    public function getHeatsourceStats($from, $to)
    {
        return ReliHeatsources::fetchStatByDate($from, $to);
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

    public function getHeatsourceRecentBlockArrayAttribute()
    {

        $multiplied = $this->heatsource_recents->map(function ($item, $key) {
            return $item->block_array;
        });

        $header = $this->block->headerBlockUnits->map( function($item, $key) {
            return $item->table_header_block_unit_array;
        });
        
        return array(
            "header" => $header,
            "content" => $multiplied
        );
    }

    public function getHeatsourceTotalStat( $group_names, $from, $to)
    {

    }

    public function getTotalNetStatPerDay( $district_ids, $from, $to)
    {
        $processed = ReliTotalNet::getAccumulateData( 
                $district_ids, $from, $to,
                array("date",
                    "temperature_perdict",
                    "temperature_actual",
                    "district_name")
            );

        $header = $this->block->headerBlockUnits->map( function($item, $key) {
            return $item->table_header_block_unit_array;
        });
        
        return array(
            "header" => $header,
            "content" => $processed
        );
    }
    
    public function getHeatsourceStatPerDay( $heatsource_ids, $from, $to)
    {
        $processed = ReliHeatsources::getAccumulateData( 
                $heatsource_ids, $from, $to,
                array("date",
                    "temperature_perdict",
                    "temperature_actual",
                    "heatsource_id",
                    "heatsource_name",
                    "heat_daily_gj")
            );

        $header = $this->block->headerBlockUnits->map( function($item, $key) {
            return $item->table_header_block_unit_array;
        });
        
        return array(
            "header" => $header,
            "content" => $processed
        );
    }
}
