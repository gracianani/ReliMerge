<?php 

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class DashboardTableBlock extends Model
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

    public function getBlockArrayAttribute()
    {
    	$values = [];

        $header = $this->block->headerBlockUnits->map( function($item, $key) {
            return $item->static_header_block_unit_array;
        });

    	foreach ($this->block->headerBlockUnits as $header_block_unit) {
    		$header=$header_block_unit->static_header_block_unit_array;
    		$content = $this->block->getTableBlockValue(
                $this->collection, $header_block_unit
            );
            array_push( $values, array(
                'header' => $header,
                'content' => $content
            ));
    	}
        
        return $values;

    }
}