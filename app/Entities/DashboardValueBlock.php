<?php 

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class DashboardValueBlock extends Model
{
    protected $table = 'heat_index_blocks';

    public $timestamps = false;

	public function block()
	{
		return $this->morphOne('App\Entities\Block', 'blockable');
	}

    public function getCollectionAttribute()
    {
        return $this->modelable_type::all();
    }

    public function modelable()
    {
        return $this->morphTo();
    }

    public function getIsCollectionAttribute()
    {
        return $this->modelable_id == 0;
    }

    public function getIsGroupByAttribute()
    {
        return !is_null($this->group_by);
    }

    public function getBlockArrayAttribute()
    {
        $header = $this->block->headerBlockUnits->map( function($item, $key) {
            return $item->static_header_block_unit_array;
        });

        $result["header"] = $header;

        $properties = $this->block->properties;

        if($this->is_collection)
        {
            $values = [];
            foreach ($this->collection as $key => $value) 
            {
                $content["name"] = $value->title;
                $content = array_merge($content , $this->block->getBlockValueByProperty(
                    $value, $properties
                ));
                array_push( $values, $content );
            }
            if($this->is_group_by)
            {
                $values = collect($values)->groupBy(function($item, $key)
                {
                    return [$key=>$item[$this->group_by]];
                });

                $values->transform(function ($item, $key) {
                    $new_value["data"] = $item;
                    return $new_value;
                });

                $values = $values->flatten(1);
            }
            
            $result["content"] = $values;
        }
        else {
            $content = $this->block->getBlockValueByProperty(
                $this->modelable, $properties
            );
            $result["content"] = $content;
        }
        return $result;
    }

}