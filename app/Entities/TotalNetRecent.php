<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\ConstDefine;
use DB;
use Carbon\Carbon;

class TotalNetRecent extends Model
{
    public $table = 'display.TotalNetRecent';

    protected $primaryKey = 'ItemID';

   
  
    // public function getHeatPerdictAttribute()
    // {
    // 	return $this->{'预计全天GJ'};
    // }

    // public function getHeatPlannedheatYesterdayAttribute()
    // {
    // 	return $this->{'昨日计划GJ'};
    // }

    // public function getHeatActualYesterdayAttribute()
    // {
    // 	return $this->{'昨日累计GJ'};
    // }

    // public function getHeatCalculateYesterdayAttribute()
    // {
    // 	return $this->{'昨日核算GJ'};
    // }

    

    public function getNameAttribute()
    {
    	return $this->title;
    }

    public function getRealtime($properties, $itemId, $from, $to, $function_name, $appends)
    {
    	$query = sprintf("select %s from %s ( %d, '%s', '%s' )", 
    		implode(',', $properties), $function_name, $itemId, $from->toDateTimeString(), $to->toDateTimeString());

    	$array = DB::select($query);
		$objects = [];
		foreach ($array as $value) {
		    $object = json_decode(json_encode($value), FALSE);
		    $result = new \StdClass;

		    $result->timestamp = Carbon::createFromFormat('Y-m-d', $object->d1)
		    	->addHours($object->h1)->timestamp;
		   	$result->{'heat_planned'} = 1;
		   	$result->{'heat_actual'} = $object->{'gj'};
		   	$result->{'heat_perdict'} = 1;
		   	$result->{'name'} = $itemId;
		   	foreach ($appends as $key=>$value) {
		   		$result->{$key} = $value;
 		   	}

		    array_push($objects, $result);
		}
    	
    	return $objects;
    }

    public function getTotalNetRecentHourly( $type, $from, $to )
    {
    	$array = DB::select(DB::raw(
    			"select * from udf_GjPerHour_TotalNet(" . $this->ItemID . ",'2015-12-31 00:00:00','2015-12-31 04:00:00')"
    			));
		$objects = [];
		foreach ($array as $value) {
		    $object = json_decode(json_encode($value), FALSE);
		    $object->{'has_timestamp'} = true;
		    $object->timestamp = Carbon::createFromFormat('Y-m-d', $object->d1)
		    	->addHours($object->h1)->timestamp;
		   	$object->{'heat_planned'} = 1;
		   	$object->{'heat_actual'} = 1;
		   	$object->{'heat_perdict'} = 1;
		    array_push($objects, $object);
		}
    	
    	return collect($objects);
    }
}
