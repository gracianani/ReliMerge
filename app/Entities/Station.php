<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Station extends Model
{
    protected $table = 'display.stations';

    protected $primaryKey = 'ItemID';

    private $hourly_function_name = 'display.stationrecents_hourly';

    private $columns = [];

    protected $casts = [
        'area_a'=>'float',
        'area_b'=>'float',
        'is_important' => 'bool',
        'is_whole' => 'bool',
        'is_water' => 'bool',
        'first_temperature_out' =>'float',
        'first_temperature_in' => 'float',
        'first_pressure_out' => 'float',
        'first_pressure_in' => 'float',
        'total_water_flow_inst' =>'float',
        'total_heat_inst' => 'float',
        'total_water_flow' => 'float',
        'total_heat' => 'float',
        'heat_index_ref' => 'float'
    ];

    public function getIdAttribute()
    {
        return $this->ItemID;
    }

    public function setColumnsAttribute($value)
    {
        $this->columns = $value;
    }

    public function company()
    {
    	return $this->belongsTo('App\Entities\Company');
    }

    public function stationAreas()
    {
    	return $this->hasMany('App\Entities\StationArea', '热力站ID');
    }

    public function sublines()
    {
        return $this->hasMany('App\Entities\Subline');
    }

    public function stationAutoControls()
    {
        return $this->hasMany('App\Entities\StationAutoControl');
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

    public function getItemArrayAttribute()
    {
        $result = [];
        foreach ($this->columns as $column) {
            if( sizeof( $column["sub_headers"]) > 0){
                $result[$column['property_name']] = $this->{$column["property_name"]}
                    ->map(
                    function($column_item, $column_key) use($column)
                    {
                        $column_item->columns = $column["sub_headers"];
                        return $column_item->item_array;
                    }
                );
            }
            else {
                $result[$column["property_name"]] = $this->{$column["property_name"]};
            }
        }
        return $result;
    }

    public function getStationArrayAttribute()
    {

        $area = $this->stationAreas->map(function($item, $key)
        {
            return $item->block_array;
        });

    	return array(
    		'id' => $this->ItemID,
    		'station_num' => $this->station_num,
    		'name' => $this->name,
    		'company_id' => $this->company_id,
    		"company" => $this->company,
    		"subcompany_id" => $this->subcompany_id,
    		"address" => $this->address,
    		"main_line" => $this->main_line,
    		"sub_line" => $this->sub_line,
    		"is_water" => $this->is_water,
    		"is_whole" => $this->is_whole,
    		"is_important" => $this->is_important,
    		"gov_district" => $this->gov_district,
    		"prod_heatsource" => $this->prod_heatsource,
    		"prod_heatsource_id" => $this->prod_heatsource_id,
    		"datasource" => $this->datasource,
    		'revenual_type' => $this->revenual_type,
    		"area_a" => $this->area_a,
    		"area_b" => $this->area_b,
    		'area_17' => $area
    	);
    }

    public function getStationRecentArrayAttribute($value='')
    {
        $multiplied = $this->sublines->map(function ($item, $key) {
            return $item->block_array;
        });
        return array(
            'id' => $this->ItemID,
            'station_num' => $this->station_num,
            'name' => $this->name,
            "company" => $this->company,
            "subcompany" => $this->subcompany,
            "first_temperature_out" => $this->first_temperature_out,
            "first_temperature_in" => $this->first_temperature_in,
            "first_pressure_out" => $this->first_pressure_out,
            "first_pressure_in" => $this->first_pressure_in,
            "total_water_flow_inst" => $this->total_water_flow_inst,
            "total_heat_inst" => $this->total_heat_inst,
            "total_water_flow" => $this->total_water_flow,
            "total_heat" => $this->total_heat,
            "sublines" => $multiplied
        );
    }

    public function getRealtimeParameters($select_parameters, $arguments)
    {
        $select_query =  implode(',', array_keys ( $select_parameters));
        $argument_query = sprintf("%d, %s, %s, %s", $this->ItemID, 
            $arguments["subline_num"], 
            "'".$arguments["from"]."'", 
            "'".$arguments["to"]."'");
        $query  = $this->getRealtimeSecond($select_query, $argument_query, 
            $select_parameters );
        return $query;
    }

    public function getRealtimeSecond ($select_query,$argument_query, $select_parameters)
    {
        $query = sprintf("select %s from %s (%s)", 
            $select_query, $this->hourly_function_name, $argument_query);
        $array = DB::select(DB::raw($query));
        $objects = [];
        foreach ($array as $value) 
        {
            $object = json_decode(json_encode($value), FALSE);
            foreach ($select_parameters as $key => $select_parameter) {
                settype($object->{$key}, $select_parameter);    
            }
            $object->timestamp = Carbon::parse($object->{'time'})->timestamp;
            array_push($objects, $object);
        }
        return $objects;
    }
}
