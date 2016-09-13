<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Log;

class HeatRecentBlock extends Model
{
    public $timestamps = false;

    protected $dates = [
        'from',
        'to',
    ];

	public function getTotalNetRecentsAttribute()
	{
		return TotalNetRecent::all();
	}

	public function block()
	{
		return $this->belongsTo('App\Entities\Block');
	}

    public function getBlockArrayAttribute()
    {
    	$values = [];
    	foreach ($this->total_net_recents as $total_net_recent) 
    	{
    		$header = $this->block->getBlockValue($total_net_recent);
    		$content = $this->block->getBlockCollectionValue(
    		    //TotalNetRecentHourly::where('total_net_recent_id',1)->get(),
                $total_net_recent->totalNetRecentHourly, 
    			$this->from, 
    			$this->to
    		);

    		array_push( $values, array(
    			'title' => $total_net_recent->title,
    			'header' => $header,
    			'content' => $content
    		));
    	}

    	return $values;
    }
}
