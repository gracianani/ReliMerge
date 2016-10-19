<?php namespace App\Services;

use App\Entities\TotalNetRecent;
use App\Entities\TotalNetHistory;

class TotalNetService
{
	public function fetchStatByDate($group_ids, $from, $to)
	{
		return TotalNetHistory::whereIn('ItemID', $group_ids)
			->where('date', '>=', $from)
            ->where('date', '<=', $to)
            ->get();
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

	public function getAccumulateData($group_ids, $from, $to, $parameters)
	{
		$totalNets = $this->fetchStatByDate(
            $group_ids,$from, $to)
            ->map(function($item, $key) {
                return $item->block_array;
            });

        $totalNets = $totalNets->unique(function ($item) {
                return $item['id'].$item['date'];
            })->groupBy("date");

        $processed = [];

        foreach ($totalNets as $key=> $totalNet) {
        	$processed_item = [];
            $processed_item["data"]=[];
        	foreach ($parameters as $parameter) {
        		if($this->isAggregate($parameter))
        		{
    				$processed_item[$parameter] = $totalNet->max($parameter);
        		}
        	}
        	$processed_item["data"]= $totalNet->map( function($item, $key) use($parameters) {
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


	public function getAttributeData( $itemId, $from, $to, $parameters)
	{
		$total_net_histories = $this->fetchStatByDate([$itemId], $from, $to);

		$multiplied = $total_net_histories->map(function ($item, $key) use ($parameters) 
		{
		    $result = [];
		    foreach ($parameters as $key => $parameter) {
		    	$result[$key] = $item->{$parameter};
		    }
		    return $result;
		});

		return $multiplied;
	}
}