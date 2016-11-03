<?php namespace App\Services;

use App\Entities\Heatsource;
use App\Entities\HeatsourceRecent;
use App\Entities\HeatsourceAccumulate;
use App\Entities\Block;
use Carbon\Carbon;

class HeatsourceService
{
	public function getValidationRules()
	{
		return $this->validate_rules;
	}

	public function getValidationMessages()
	{
		return $this->validation_messages;
	}

	private $validate_rules = [
        'id' => 'required|numeric|exists:HeatSources,ItemID',
        'heatsource_num' => 'string|max:20',
        'name' => 'string|max:20',
        'address' => 'string|max:100',
        'year_of_built' => 'date_format:Y',
        'area' => 'numeric|max:65535',
        'admin' => 'string',
        "phone" => 'digits_between:8,11', 
        "type" => 'in:燃煤,燃气,燃油', 
        "is_gas" => 'boolean', 
        "inner_or_outer" => 'in:内部,外部', 
        "district" => 'exists:display.districts,name', 
        "is_whole" => 'boolean', 
        "heat_capacity" => 'numeric', 
        "max_hourly_heat_capacity" => 'numeric', 
        "max_daily_heat_capacity" => 'numeric',
        "max_day_hourly_heat_capacity" => 'numeric', 
        "water_cycle" => 'numeric', 
        "max_water_cycle" => 'numeric',
        "additional_water" => 'numeric',
        "max_inst_additional_water" => 'numeric', 
        "max_daily_additional_water" => 'numeric', 
        "max_monthly_additional_water" => 'numeric',
        "daily_gas_usage" => 'numeric', 
        "hourly_gas_usage" =>'numeric', 
        "num_of_ovens" => 'numeric', 
        "oven_heat_capacity" => 'numeric'
   	];

   	private $validation_messages = [
        'date_format' => '日期格式错误',
        'exists'=>'不存在:attribute',
        'required' => '缺少 :attribute 参数.',
        'numberic' => ':attribute 类型错误，只接受数字',
        'string' => ':attribute 类型错误',
        'in' => ':attribute 赋值错误',
        'boolean' => ':attribute 类型错误，只接受0或1'
    ];

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

	public function fetch($id)
	{
		return HeatSource::find($id);
	}

	public function fetchAll()
	{
		return HeatSource::all();
	}

	public function fetchAllRealtime()
	{
		return HeatsourceRecent::all();
	}

	public function fetchRealtimeByParameter($id, $parameter)
	{
		return HeatsourceRecent::find($id)->getRealtimeParameters(
			[$parameter], Carbon::now()->addHours(-1), Carbon::now());
	}

	public function fetchStatByDate($from, $to)
	{
		return HeatsourceAccumulate::
			where('date', '>=', $from)
            ->where('date', '<=', $to)->get();
	}

	public function update( $id, $data )
	{
		$heatSource = HeatSource::find($id);
		$heatSource->update( $data );
		return true;
	}

	public function batchUpdate( $data)
	{
		foreach ($data as $data_item) {
			$heatSource = HeatSource::find($data_item['id']);
			$heatSource->update( $data_item );
		}
		return true;
	}

	public function filterByHeatsourceId($heatsource_ids, $from, $to )
	{
		$heatsource_ids=[1,3,4,5,6,20,21,22];
		return HeatsourceAccumulate::whereIn('heatsource_id', $heatsource_ids)
			->where('date', '>=', $from)
            ->where('date', '<=', $to)->get();
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
        	foreach ($parameters as $parameter) {
        		if($this->isAggregate($parameter))
        		{
    				$processed_item[$parameter] = $heatsource->max($parameter);
        		}
        	}
        	$results = $heatsource->map( function($item, $key) use($parameters) {
				$result = [];
				foreach ($parameters as $parameter) {
	        		$result[$parameter] = $item[$parameter];
	        	}
				return $result;
			});
            array_push($processed, $results->toArray());
        }

        return $processed;
	}
}