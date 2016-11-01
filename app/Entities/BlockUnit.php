<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class BlockUnit extends Model
{
    public $timestamps = false;

    protected $casts = [
        'is_sortable' => 'boolean',
        'is_filterable' => 'boolean',
        'is_editable' => 'boolean',
        'is_visible' => 'boolean',
        'is_hoverable' => 'boolean',
        "filter_min" => 'float',
        'filter_max' => 'float'
    ];

	public function blocks()
    {
        return $this->belongsToMany('App\Entities\Block');
    }

    public function children()
    {
        return $this->hasMany('App\Entities\BlockUnit', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Entities\BlockUnit', 'parent_id');
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
            case 'boolean';
                return array(
                    'type' => $this->filter_type,
                    "available_items" => ["是", "否"]
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
            "is_hoverable" => $this->is_hoverable,
    		"filter" => $this->filter,
            "sub_headers"=> $this->children->map( function($item, $key) {
                return $item->table_header_block_unit_array;
            })->sortBy('sequence')->values()
    	);
    }

    public function getStaticHeaderBlockUnitArrayAttribute()
    {
        return array(
            "title" => $this->title,
            "unit" => $this->unit,
            "value"=>$this->value,
            "property_name" => $this->property_name
        );
    }
    
    public function getTableContentBlockUnitArrayAttribute()
    {
        return array(
            "title" => $this->title,
            "unit" => $this->unit
        );
    }
    
}
