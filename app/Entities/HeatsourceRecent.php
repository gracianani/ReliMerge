<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

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
            'subline_id' => $this->subline_id,
            'temperature_out' => $this->temperature_out,
            'temperature_in' => $this->temperature_in,
            'pressure_out' => $this->pressure_out,
            'pressure_in' => $this->pressure_in,
            'water_flow_out' => $this->water_flow_out,
            'water_flow_out_inst' => $this->water_flow_out_inst,
            'water_heat_out' => $this->water_heat_out,
            'water_heat_out_inst' => $this->water_heat_out_inst,
            'heat' => $this->heat,
            'heat_inst' => $this->heat_inst,
            'additional_water_inst' => $this->additional_water_inst,
            'additional_water' => $this->additional_water,
            'water_flow_in' => $this->water_flow_in,
            'water_flow_in_inst' => $this->water_flow_in_inst,
            'heat_today_gj' => $this->heat_today_gj,
       //     'created_at' => $this->created_at
        );
    }
}
