<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class BlockUnit extends Model
{
	public function blocks()
    {
        return $this->belongsToMany('App\Entities\Block');
    }

    public function getFilterAttribute()
    {
    	switch ($this->filter_type) {
    		case 'range':
    			return array(
		    		"type" => $this->filter_type,
		    		"min" => $this->filter_min,
		    		"max" => $this->filter_max
		    	);
    		case 'text' :
    			return array(
		    		"type" => $this->filter_type
		    	);
    		case 'dropdown':
    		$query =  DB::table($this->filter_table_name)->pluck($this->filter_column_name);
    			return array(
		    		"type" => $this->filter_type,
		    		"available_items" => $query
		    	);
    		default:
    			return null;
    	}
    	
    }

    public function getTableHeaderBlockUnitArrayAttribute()
    {
    	return array(
    		"sequence" => $this->sequence,
    		"property_name" => $this->property_name,
    		"title" => $this->title,
    		"unit" => $this->unit,
    		"is_visible" => $this->is_visible,
    		"is_editable"=> $this->is_editable,
    		"is_sortable" => $this->is_sortable,
    		"is_filterable" => $this->is_filterable,
    		"filter" => $this->filter
    	);
    }
}

class BlockUnitType 
{
	const HEADER = 1;
	const CONTENT = 2;
}
