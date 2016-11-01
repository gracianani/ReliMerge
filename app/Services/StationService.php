<?php namespace App\Services;

use App\Entities\Station;
use App\Entities\Subline;
use App\ConstDefine;
use App\Entities\ControlChangeLog;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class StationService
{

	public function fetchAll()
	{
		return Station::all();
	}

	public function fetch($id)
	{
		return Station::find($id);
	}

	public function fetchSubline($id)
	{
		return Subline::find($id);
	}

	public function fetchSublineBySublineNum($station_id, $subline_num)
	{
		return Subline::where('station_id' , $station_id)->whereLike('subline_num', '%'.$subline_num.'%')->get();
	}

//{"is_water": true, "is_whole": true, "area": [1,100] , "name" : "西八里"} 

	private function parseFilterParameters($attributes, $headers)
	{
		$querys = [];
		foreach ($attributes as $property_name => $attribute ) {
			$filtered = $headers->first(function ($value, $key) use ($property_name) {
			    return $value["property_name"] == $property_name;
			});
			$type = array_get($filtered, 'filter.type');
			$query = '';
			switch($type)
			{
				case 'range' : 
					$query = sprintf(" %s between %f and %f", $property_name, $attribute[0], $attribute[1]);
					array_push($querys, $query);
					break;
				case 'text' : 
					$query = sprintf(" %s like '%%%s%%' ", $property_name, $attribute);
					array_push($querys, $query);
					break;
				case 'dropdown' : 
					$query = sprintf(" %s = %d", $property_name, $attribute);
					array_push($querys, $query);
					break;
				case 'boolean':
					$query = sprintf(" %s = %d", $property_name, $attribute);
					array_push($querys, $query);
					break;
			}
		}
		return implode(' and ', $querys);
	}


	public function filter($attributes, $headers)
	{
		$raw_query = $this->parseFilterParameters($attributes, $headers);
		$stations = Station::when($raw_query, function($query) use($raw_query) {
			return $query->whereRaw($raw_query);
		})->get();
		return $stations;
	}

	public function addChangeLog($station, $subline, $change_item_id, $value)
	{
			$control_change_log = new ControlChangeLog;
			$control_change_log->station_id = $station->ItemID;
			$control_change_log->subline_num = $subline->subline_num;
			$control_change_log->changeItemId = $change_item_id;
			$control_change_log->valueInt = $value;
			$control_change_log->operator = 1; 
			$control_change_log->optime = Carbon::now('Asia/Shanghai');
			$control_change_log->isProcessed = false;
			$control_change_log->save();
	}

	public function updateControl($station, $subline, $changes)
	{
		$ordered_changes = collect($changes)->sortBy('change_item_id');

		foreach ($ordered_changes as $change_data_item) {
			$change_item_id = $change_data_item["change_item_id"];
			$value_int = 0;
			$value_decimal = 0.0;

			$data = json_decode( json_encode($change_data_item["data"]) ); 
			switch ($change_item_id) {
				case 1:
					$value_int = $data;
					$subline->control_mode = $value_int;
					break;
				case 2: 
					$value_int = $data;
					$subline->second_temperature_out_control_mode = $value_int;
					break;
				case 3:
					$subline->startTime = $data->startTime;
					$subline->endTime = $data->endTime;
					$subline->lowTemp = $data->lowTemp;
					$value_int = 3;
					break;
				case 5:
					for ($i=1; $i <= 12; $i++) { 
						$subline->timeAutoControlLineOne->{'time'.$i} = 
							$data->{'time'. $i};
					}
					break;
				case 6:
					for ($i=1; $i < 12; $i++) { 
						$subline->timeAutoControlLineTwo->{'time'.$i} = 
							$data->{'time'. $i};
					}
					break;
				case 7 : 
					for ($i=1; $i < 7; $i++) { 
						$subline->temperatureAutoControlLineOne->{'Temp'.$i} =
							$data->{'temp'.$i};
					}
					break;
				case 8 : 
					for ($i=1; $i < 7; $i++) { 
						$subline->temperatureAutoControlLineTwo->{'Temp'.$i} =
							$data->{'temp'.$i};
					}
					break;
				case 20:
					$value_decimal = $data->value;
					$subline->T1h_limit = $value_decimal;
					break;
				case 21:
					$value_decimal = $data->value;
					$subline->valve_sp = $value_decimal;
					break;
				case 22:
					$value_decimal = $data->value;
					$subline->T2g_sp = $value_decimal;
					break;
				case 23:
					$value_decimal = $data->value;
					$station->valve_sp = $value_decimal;
					break;
				case 24:
					$value_decimal = $data->value;
					$station->T1h_limit = $value_decimal;
					break;
			}
			$station->save();
			$subline->save();
			$this->addChangeLog($station, $subline, $change_item_id, $value_int, $value_decimal);
		}
	}
}