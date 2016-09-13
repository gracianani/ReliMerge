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
        return $this->belongsToMany('App\Entities\BlockUnit')->withPivot('is_sortable', 'is_filterable', 'filter_type', 'filter_min', 'filter_max');
    }
    public function headerBlockUnits()
    {
        return $this->belongsToMany('App\Entities\BlockUnit')->wherePivot('type_id', BlockUnitType::HEADER);
    }

    public function contentBlockUnits()
    {
        return $this->belongsToMany('App\Entities\BlockUnit')->wherePivot('type_id',  BlockUnitType::CONTENT);
    }

    public function getBlockValue($model)
    {
        $content_array = [];

        foreach ($this->headerBlockUnits as $block_unit) 
        {
            array_push( 
                $content_array,
                array(
                    "type" => $block_unit->property_name,
                    "unit" => $block_unit->unit,
                    "title" => $block_unit->title,
                    "value" => $model->{$block_unit->property_name} 
                )
            ); 
        }

        return $content_array;
    }

    public function getBlockCollectionValue($models, $from = null, $to = null)
    {
        $content_array = [];

        if(is_null($from) || is_null($to))
        {
            $filtered = $models;
        }
        else {
            $filtered = $models->filter( function($value, $key) use($from, $to) {
                return $value->created_at >= $from && 
                    $value->created_at < $to;
            });
        }
        
        foreach ($this->contentBlockUnits as $block_unit) 
        {
            $multiplied = $filtered->map(function ($item, $key) use($block_unit) {
                return array(
                    "timestamp" => $item->created_at->timestamp,
                    "value" => $item->{$block_unit->property_name}
                );
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
}
