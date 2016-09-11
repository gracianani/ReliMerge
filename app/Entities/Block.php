<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    function blockable() {
    	return $this->morphTo();
    }

    public function blockUnits()
    {
        return $this->belongsToMany('App\BlockUnit');
    }

    public function getBlockValue($model)
    {
        $content_array = [];

        foreach ($this->blockUnits as $block_unit) 
        {
            $content_array = 
                array_push( 
                    $content_array,
                    array(
                        "unit" => $block_unit->unit,
                        "title" => $block_unit->title,
                        "value" => $model->{$block_unit->property_name} 
                    )
                ); 
        }

        return $content_array;
    }

    public function getBlockCollectionValue($models, $from, $to)
    {
        $content_array = [];

        $filtered = $models->filter( function($value, $key) use($from, $to) {
            return $value->last_updated_at >= $from && 
                $value->last_updated_at < $to;
        });

        foreach ($this->blockUnits as $block_unit) 
        {
            $content_array = 
                array_push( 
                    $content_array,
                    array(
                        "unit" => $block_unit->unit,
                        "title" => $block_unit->title,
                        "data" => $filtered->lists($block_unit->property_name) 
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
    	}
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
