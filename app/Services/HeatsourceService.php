<?php namespace App\Services;

use App\Entities\HeatSource;
use App\Entities\HeatSourceRecent;
use App\Entities\HeatsourceAccumulate;
use App\Entities\Block;

class HeatsourceService
{
	public function getHeatsourcesByGroupName( $group_name )
	{
		switch( $group_name ) {
			case ConstDefine::GROUP_EAST:
				return HeatSource::east();
			case ConstDefine::GROUP_WEST:
				return HeatSource::west();
		}
		return HeatSource::all();
	}

	public function fetchAll()
	{
		return HeatSource::all();
	}

	public function fetchAllRealtime()
	{
		return HeatsourceRecent::all();
	}

	public function fetchStatByDate($from, $to)
	{
		return HeatsourceAccumulate::where('date', '>', $from)
            ->where('date', '<', $to)->get();
	}

	public function filterByHeatsourceId($heatsource_ids, $from, $to )
	{
		return HeatsourceAccumulate::whereIn('heatsource_id', $heatsource_ids)->where('date', '>', $from)
            ->where('date', '<', $to)->get();
	}

	public function isAggregate($parameter)
	{
		switch($parameter)
		{
			case 'date':
			case 'temperature_perdict':
			case 'temperature_actual':
				return true;
			default:
				return false;
		}
	}

	public function getAccumulateData($heatsource_ids, $from, $to, $parameters)
	{
		$heatsources = $this->filterByHeatsourceId(
            $heatsource_ids,$from, $to)
            ->map(function($item, $key) {
                return $item->block_array;
            });
        $heatsources = $heatsources->unique(function ($item) {
                return $item['heatsource_id'].$item['date'];
            })->groupBy("date");

        $processed = [];

        foreach ($heatsources as $key=> $heatsource) {
        	$processed_item = [];
            $processed_item["data"]=[];
        	foreach ($parameters as $parameter) {
        		if($this->isAggregate($parameter))
        		{
    				$processed_item[$parameter] = $heatsource->max($parameter);
        		}
        		else {
        			$s = [];
        			$heatsource->each(function($item) use ($parameter, $s)
        				{
        					var_dump($item[$parameter]);
        					var_dump($s);	
        					array_push( $s, $item[$parameter] );
        				}
        			);
        			var_dump($s);
        			exit(1);
        			array_add( $processed_item["data"] , $parameter, $s);
        		}
        	}
        	/*
            $processed_item = array(
                "date" => $key,
                "temperature_perdict" => $heatsource->max('temperature_perdict'),
                "temperature_actual" => $heatsource->max('temperature_actual')
            );
            $processed_item["data"]=[];
            foreach ($heatsource as $heatsource_by_item) {
                array_push( $processed_item["data"], 
                    array( "id" => $heatsource_by_item["heatsource_id"],
                        "heatsource_name" => $heatsource_by_item["heatsource_name"],
                        "heat_daily_gj" => $heatsource_by_item["heat_daily_gj"],
                        "heat_per_square_actual" => $heatsource_by_item["heat_per_square_actual"],
                        "area_in_use"=> $heatsource_by_item["area_in_use"],
                    )
                );
            }*/
            array_push($processed, $processed_item);
        }

        return $processed;
	}

	public function getBlock( $block_name )
	{
		$block = Block::where('module', $block_name)->first();
        $heatsource_block = $block->blockable;
        return $heatsource_block;
	}
}