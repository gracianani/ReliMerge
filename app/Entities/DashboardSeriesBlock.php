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
            return Carbon::create(2015, 12, 1)->copy()->add($carbon_offset);
        }
        return Carbon::today();
    }

    public function getHourlyToAttribute()
    {
        if(! is_null($this->hourly_to_offset)) {
            $carbon_offset = CarbonInterval::createFromDateString ($this->hourly_to_offset);
            return Carbon::today()->copy()->add($carbon_offset);
        }
        return Carbon::create(2015, 12, 2);
    }

    // public function getBlockArrayAttribute()
    // {
    //     return $this->block_b_array;
    // 	$values = [];
    //     foreach ($this->collection as $total_net_recent) 
    //     {
    //         $header = $this->block->getBlockValue($total_net_recent);
    //         $content = $this->block->getBlockCollectionValue(
    //             $total_net_recent->getTotalNetRecentHourly(4, $this->from, $this->to) 
    //         );

    //         array_push( $values, array(
    //             'title' => $total_net_recent->title,
    //             'header' => $header,
    //             'content' => $content
    //         ));
    //     }
    // 	return $values;
    // }

    // public function getBlockAArrayAttribute()
    // {
    //     $all_values=[];
    //     $headers = $this->block->headerBlockUnits->map( function($item, $key) {
    //         return $item->static_header_block_unit_array;
    //     });

    //     $from = Carbon::createFromDate(2015,12,1);
    //     $to = Carbon::createFromDate(2015,12,8);
    //     $groups = ["东部" => 1, "西部" => 2, "全网" => 3];
    //     foreach ( $groups as $key => $value) {
    //         $values = [];
    //         foreach ($headers as $header) {
    //             $content = ReliTotalNet::getAttributeData($value, $from, $to, [ "value"=>$header["property_name"],"timestamp"=>"timestamp" ]);
    //             array_push( $values, array(
    //                 'unit' => $header["unit"],
    //                 'title' => $header["title"],
    //                 'data' => $content
    //             ));
    //         }
    //         array_push($all_values, array(
    //             'title' => $key,
    //             'header' => null,
    //             "content" => $values
    //         ));
    //     }
        
    //     return $all_values;
    // }

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
                if($this->has_hourly_function)
                {
                    $content =  $value->getRealtime(
                        ['*'], $value->ItemID, $this->hourly_from, $this->hourly_to, 
                        $this->hourly_function_name, array('name'=>$value->title)
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
