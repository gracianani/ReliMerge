<?php 

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class DashboardCompareBlock extends Model
{
	protected $table = 'dashboard_table_blocks';

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

    public function getDataItemsAttribute()
    {
        if($this->is_collection)
        {
            return $this->collection;
        }
        else {
            return array($this->modelable);
        }
    }
    
    public function getBlockArrayAttribute()
    {
        $header = $this->block->headerBlockUnits->map( function($item, $key) {
            return $item->static_header_block_unit_array;
        });

        $result["header"] = $header;

        $properties = $this->block->properties;
        $compare_with_properties = collect( $this->block->properties )->map( function($item)
        {
            return sprintf($this->format, $item);
        });
        
        $values = [];
        foreach ($this->data_items as $key => $value) 
        {
            $content["name"] = "今日";
            $content = array_merge($content , $this->block->getBlockValueByProperty(
                $value, $properties
            ));
            array_push( $values, $content );

            $compare_content["name"] = "昨日";
            $compare_content = array_merge($compare_content , $this->block->getBlockValueByProperty(
                $value, $compare_with_properties
            ));
            array_push( $values, $compare_content );
        }
        
        $result["content"] = $values;
    
        return $result;
    }

}