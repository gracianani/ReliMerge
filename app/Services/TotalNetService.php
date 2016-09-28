<?php namespace App\Services;

use App\Entities\TotalNetRecent;
use App\Entities\TotalNetHistory;

class TotalNetService
{
	public function fetchStatByDate($from, $to)
	{
		return TotalNetHistory::where('date', '>', $from)
            ->where('date', '<', $to)->get();
	}

	private function isAggregate($parameter)
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
}