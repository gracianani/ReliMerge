<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    public $timestamps = false;

    public $append = ['block_array'];

    public function blockable() {
    	return $this->morphTo();
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
}
