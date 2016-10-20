<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class HeatsourceRecent extends Model
{
    protected $table = 'HeatSourceRecent';

    protected $primaryKey = 'ItemID';

    public function heatsource()
    {
    	return $this->belongsTo('App\Entities\Heatsource');
    }

    public function getBlockArrayAttribute()
    {
        return array(
            'id' => $this->ItemID,
            'heat_source_num' => $this->heat_source_num,
            'name' => $this->name,
            'subline_name' => $this->subline_name,
            'subline_num' => $this->subline_num,
            'temperature_out' => $this->temperature_out,
            'temperature_in' => $this->temperature_in,
            'pressure_out' => $this->pressure_out,
            'pressure_in' => $this->pressure_in,
            'water_flow_out' => $this->water_flow_out,
            'water_heat_out' => $this->water_heat_out,
            'heat' => $this->heat,
            'water_flow_out_inst' => $this->water_flow_out_inst,
            'water_heat_out_inst' => $this->water_heat_out_inst,
            'heat_inst' => $this->heat_inst,
            'additional_water_inst' => $this->additional_water_inst,
            'additional_water' => $this->additional_water,
            'water_flow_in' => $this->water_flow_in,
            'water_flow_in_inst' => $this->water_flow_in_inst,
            'water_heat_in' => $this->water_heat_in,
            'water_heat_in_inst' => $this->water_heat_in_inst,
            'heat_today_gj' => $this->heat_today_gj,
        );
    }


    public function getRealtimeParameters($parameters, $from, $to)
    {
        $properties = $parameters;
        $parameters = ['一次供温 as temperature_out', '时间 as t'];
        $content =  $this->getRealtime(
            $parameters, $this->ItemID, $from, $to, 
            'station1stHistory', array('name'=>$this->name)
        );
        return $content;
    }

    public function getRealtime($properties, $itemId, $from, $to, $function_name, $appends)
    {
        $query = sprintf("select %s from %s where 时间 between '%s' and '%s' and 热力站ID = 10 ", 
            implode(',', $properties), $function_name, '2016-01-01 00:00:00', '2016-01-01 01:00:00', $itemId);

        $array = DB::select(DB::raw($query));
        $objects = [];
        foreach ($array as $value) {
            $object = json_decode(json_encode($value), FALSE);
            $result = new \StdClass;

            $result->timestamp = Carbon::parse($object->{'t'})->timestamp;
            $result->temperature_out = $object->{'temperature_out'};
            foreach ($appends as $key=>$value) {
                $result->{$key} = $value;
            }

            array_push($objects, $result);
        }
        
        return $objects;
    }
}
