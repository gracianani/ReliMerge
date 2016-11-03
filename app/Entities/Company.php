<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\ConstDefine;
use DB;
use Carbon\Carbon;

class Company extends Model
{
    public $table = 'display.companies';

    protected $primaryKey = 'ItemID';

    protected $casts = [
        "heat_index_ref" => 'float',
        "heat_index_actual" => 'float', 
        'heat_index_planned' => 'float',
        'heat_index_calculate' => 'float',
        'heat_perdict' => 'float',
        'area_planned' => 'float',
        "area_actual" => 'float',
        "heat_planned_yesterday" => 'float',
        "heat_actual_yesterday" => 'float',
        "heat_calculate_yesterday" => 'float',
        'heat_index_planned_yesterday' => 'float',
        'heat_index_calculate_yesterday' => 'float',
        'heat_index_actual_yesterday' => 'float',
        'total_area_in_use_actual' => 'float',
        'total_area_in_use_planned' => 'float',
        'heat_planned' => 'float',
        'heat_actual' => 'float'
    ];

    public function getNameAttribute()
    {
    	return ConstDefine::getDistrictName($this->ItemID);
    }

    public function getRealtime($properties, $itemId, $from, $to, $function_name, $appends)
    {
        $select_query = implode(',', $properties);
    	$query = sprintf("select %s from %s ( %d, '%s', '%s' )", 
    		$select_query, $function_name, $itemId, $from->toDateTimeString(), $to->toDateTimeString());
    	$array = DB::select($query);
		$objects = [];
		foreach ($array as $value) {
		    $object = json_decode(json_encode($value), FALSE);
		    $result = new \StdClass;
		    $result->timestamp = Carbon::createFromFormat('Y-m-d', $object->d1)
		    	->addHours($object->h1)->timestamp;
		   	foreach ($appends as $key=>$value) {
                $result_value = $object->{$value};
                if(is_numeric($result_value))
                {
                    $result_value = (float) $result_value; 
                }
		   		$result->{$key} = $result_value;
 		   	}
		    array_push($objects, $result);
		}
    	return $objects;
    }

}
