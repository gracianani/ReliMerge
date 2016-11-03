<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class StationArea extends Model
{
    protected $table = 'Stations_Area17';

    private $columns = [];

    protected $casts = [
        'Area'=>'float',
    ];

    public function setColumnsAttribute($value)
    {
        $this->columns = $value;
    }

    public function getAreaCodeAttribute()
    {
    	return 
    	AreaCode::where('Separate_Code', $this->Separate_Code)->where('Class_Code', $this->Class_Code)->first();
    }

    public function getNameAttribute()
    {
        return $this->area_code->Class_Desc;
    }

    public function getBlockArrayAttribute()
    {
    	return array(

    		'name' => $this->area_code->Class_Desc,
    		'Class_Code' => $this->Class_Code,
    		'Separate_Code' => $this->Separate_Code,
    		'Area' => $this->Area
    	);
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
}


class AreaCode extends Model
{
	protected $table = 'Area17_Code';
}