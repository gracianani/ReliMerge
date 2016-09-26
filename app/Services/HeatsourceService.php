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
        	}
        	$processed_item["data"]= $heatsource->map( function($item, $key) use($parameters) {
				$result = [];
				foreach ($parameters as $parameter) {
	        		if(!$this->isAggregate($parameter))
	        		{
	        			$result[$parameter] = $item[$parameter];
	        		}
	        	}
				return $result;
			});
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