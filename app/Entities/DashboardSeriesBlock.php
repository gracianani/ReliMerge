<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Factory;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use ReliTotalNet;

class DashboardSeriesBlock extends Model
{
    protected $table = 'heat_recent_blocks';

    public $timestamps = false;

	public function getTotalNetRecentsAttribute()
	{
		return TotalNetRecent::all();
	}

	public function block()
	{
		return $this->belongsTo('App\Entities\Block');
	}

    public function getCollectionAttribute()
    {
        return $this->modelable_type::when($this->is_filter_collection, function($query) {
            return $query->whereBetween('date',[ '2015-11-7', '2015-11-14']);
        })->when($this->is_filter_by_current_user_id, function($query){
            return $query->where('ItemID', $this->user->company_id);
        })->get();
            //$this->from->toDateTimeString(), $this->to->toDateTimeString()]);
       // })->get();
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

    public function getGroupsAttribute()
    {
        return $this->modelable_type::unique($this->group_by)->values()->all();
    }

    public function getFromAttribute()
    {
        if(! is_null($this->from_offset)) {
            $carbon_offset = CarbonInterval::createFromDateString ($this->from_offset);
            return Carbon::now()->copy()->sub($carbon_offset);
        }
        return Carbon::today();
    }

    public function getToAttribute()
    {
        if(! is_null($this->to_offset)) {
            $carbon_offset = CarbonInterval::createFromDateString ($this->to_offset);
            return Carbon::now()->copy()->add($carbon_offset);
        }
        return Carbon::now();
    }

    public function getHourlyFromAttribute()
    {
        if(! is_null($this->hourly_from_offset)) {
            $carbon_offset = CarbonInterval::createFromDateString ($this->hourly_from_offset);
            return Carbon::create(2015, 12, 1, 0, 0, 0)->copy()->add($carbon_offset);
        }
        return Carbon::today();
    }

    public function getHourlyToAttribute()
    {
        if(! is_null($this->hourly_to_offset)) {
            $carbon_offset = CarbonInterval::createFromDateString ($this->hourly_to_offset);
            $to =  Carbon::create(2015, 12, 1, 0, 0, 0)->add($carbon_offset);
            return $to;
        }
        return Carbon::now();
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
        
        $values = [];

        foreach ($this->data_items as $key => $value) 
        {

            $content["name"] = $value->title;
            if($this->has_hourly_function)
            {
                $content =  $value->getRealtime(
                    ['*'], $value->ItemID, $this->hourly_from, $this->hourly_to, 
                    $this->hourly_function_name, array(
                        'heat_actual' =>'gj',
                        'heat_planned' => 'heat_planned',
                        'heat_perdict' => 'heat_perdict',
                        'name'=>'name')
                );
            }
            else{
                $content = array_merge($content , $this->block->getBlockValueByProperty(
                    $value, $properties
                ));
            }
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
     
        return $result;
    }

}
