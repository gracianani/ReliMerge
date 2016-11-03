<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    public $timestamps = false;

    public $append = ['block_array'];

    public function blockable() {
    	return $this->morphTo();
    }

    public function role()
    {
        return $this->belongsTo('App\Entities\Role');
    }

    public function direction()
    {
        return $this->belongsTo('App\Entities\Direction',  'display_direction_id');
    }

    public function stack()
    {
        return $this->belongsTo('App\Entities\Stack', 'display_dropdown_id');
    }

    public function graph()
    {
        return $this->belongsTo('App\Entities\Graph', 'display_graph_id');
    }

    public function setModelableIdAttribute($value)
    {
        $blockable = $this->blockable;
        if(!is_null($blockable))
        $blockable->modelable_id = $value;
    }

    public function blockUnits()
    {
        return $this->belongsToMany('App\Entities\BlockUnit');
    }
    public function headerBlockUnits()
    {
        return $this->belongsToMany('App\Entities\BlockUnit')->wherePivot('type_id', BlockUnitType::HEADER);
    }

    public function contentBlockUnits()
    {
        return $this->belongsToMany('App\Entities\BlockUnit')->wherePivot('type_id',  BlockUnitType::CONTENT);
    }

    public function getTableBlockValue($collection, $block_unit)
    {
        $result = array(
            "title" => $block_unit->title,
            "unit" => $block_unit->unit,
            "data" => $collection->map( function ($value) use($block_unit)
            {
                return array($value->title => $value->{$block_unit->property_name});
            })
        );
        return $result;
    }

    public function getBlockValue($model, $block_type=BlockUnitType::HEADER)
    {
        $content_array = [];
        $block_units = [];
        if($block_type == BlockUnitType::HEADER)
        {
            $block_units = $this->headerBlockUnits;
        }
        else {
            $block_units = $this->contentBlockUnits;
        }
        foreach ($block_units as $block_unit) 
        {
            $result = array(
                "type" => $block_unit->property_name,
                "unit" => $block_unit->unit,
                "title" => $block_unit->title
            );
            if($block_type == BlockUnitType::HEADER)
            {
                $result["value"] = $model->{$block_unit->property_name};
            }
            else 
            {
                $result["data"] = array(
                    "value" => $model->{$block_unit->property_name}
                );
            }
            array_push( 
                $content_array,
                $result
            ); 
        }

        return $content_array;
    }

    public function getBlockValueByProperty($model, $properties=[])
    {
        $content_array = [];
        foreach ($properties as $property) 
        {
            $content_array[$property] = $model->{$property};
        }
        return $content_array;
    }

    public function getBlockCollectionValue($collection, $properties = [])
    {
        $content_array = [];

        foreach ($this->contentBlockUnits as $block_unit) 
        {
            $multiplied = $collection->map(function ($item, $key) use($block_unit) {
                $result = [];
                if($item->has_timestamp)
                {
                    $result['timestamp'] = $item->timestamp;
                }
                $result['value'] = $item->{$block_unit->property_name};
                return $result;
            });

            array_push( 
                $content_array,
                array(
                    "type" => $block_unit->property_name,
                    "unit" => $block_unit->unit,
                    "title" => $block_unit->title,
                    "data" => $multiplied
                )
            ); 
        }
        return $content_array;
    }

    public function getDisplayAttribute()
    {
    	$display = '';

    	switch ($this->display_direction_id) {
    		case DisplayValue::HORIZONTAL:
    			$display = 'horizontal';
    			break;
    		case DisplayValue::VERTICAL:
    			$display = 'vertical';
    			break;
    	}

    	switch ($this->display_dropdown_id) {
    		case DisplayValue::ALL :
    			$display = $display . '_all';
    			break;
    		case DisplayValue::DROPDOWN;
    			$display = $display . '_dropdown';
    			break;
    	}

    	switch ($this->display_graph_id) {
    		case DisplayValue::LINE :
    			$display = $display . '_line';
    			break;
    		case DisplayValue::BAR;
    			$display = $display . '_bar';
    			break;
    		case DisplayValue::RADAR :
    			$display = $display . '_radar';
    			break;
    		case DisplayValue::POLAR_AREA;
    			$display = $display . '_polarArea';
    			break;
    		case DisplayValue::PIE :
    			$display = $display . '_pie';
    			break;
    		case DisplayValue::DOUGHNUT;
    			$display = $display . '_doughnut';
    			break;
    		case DisplayValue::BUBBLE;
    			$display = $display . '_bubble';
    			break;
            case DisplayValue::TABLE;
                $display = $display . '_table';
                break;
    	}

        return $display;
    }

    public function getBlockArrayAttribute()
    {
    	return array(
    		"id" => $this->id,
    		"title"=> $this->title,
    		"size" => $this->size,
    		"display" => $this->display,
    		"data" => $this->blockable->block_array
    	);
    }

    public function getPropertiesAttribute()
    {
        $header = $this->headerBlockUnits->map( function($item, $key) {
            return $item->static_header_block_unit_array;
        });

        $properties = array_column($this->headerBlockUnits->toArray(), 'property_name');
        return $properties;
    }

    public function getTableHeaderBlockUnitArrayAttribute()
    {
        $header = $this->headerBlockUnits->map( function($item, $key) {
            return $item->table_header_block_unit_array;
        })->sortBy('sequence')->values();

        return $header;
    }

    public function getStaticHeaderBlockUnitArrayAttribute()
    {
        $header = $this->headerBlockUnits->map( function($item, $key) {
            return $item->static_header_block_unit_array;
        })->sortBy('sequence')->values();

        return $header;
    }

    public function getHeaderBlockUnitArray( $header_display_type, $sortBy = 'sequence', $filter='')
    {
        $header = $this->headerBlockUnits->map( function($item, $key) use($header_display_type) {
            return $item->{$header_display_type};
        })->sortBy($sortBy)->values();
        if($filter !== '')
        {
            $header = $header->filter(function ($value, $key) use($filter) {
                return $value["property_name"] == $filter;
            });
        }
        return $header;
    }


    public function applyCustomSettings($header_display_type, $sort_by = 'sequence', $filter='', $user=null)
    {
        if( $user === null) {
            $user = User::find(1);
        }

        $current_header = $this->getHeaderBlockUnitArray($header_display_type);
        
        if(!$user->settings->contains('module_name', $this->module))
        {
            return $current_header;
        }
        $user_setting = $user->settings->first( function($value, $key) {
            return $value->module_name ==  $this->module;
        });

        $setting_value = collect( json_decode($user_setting->setting_value, true) );
        $current_header->transform(
            function ($item, $key) use($setting_value) {
            if($setting_value->contains("property_name", $item["property_name"]))
            {
                $property_name = $item["property_name"];
                $the_setting = $setting_value->first( function($value, $key) use( $property_name ) {
                    return $value["property_name"] ==  $property_name;
                });

                $item["is_visible"] = $the_setting["is_visible"];
            }
            return $item;
        });
        return $current_header;
    } 
}
