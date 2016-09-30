<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class StationArea extends Model
{
    protected $table = 'Stations_Area17';

    public function getAreaCodeAttribute()
    {
    	return 
    	AreaCode::where('Separate_Code', $this->Separate_Code)->where('Class_Code', $this->Class_Code)->first();
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

}


class AreaCode extends Model
{
	protected $table = 'Area17_Code';
}