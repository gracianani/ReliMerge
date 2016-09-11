<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class HeatRecentBlock extends Model
{
	public function totalNetRecents()
	{
		return TotalNetRecent::all();
	}

	public function block()
	{
		return $this->hasOne('App\Block');
	}

    public function getBlockArrayAttribute()
    {
    	$values = [];
    	foreach ($this->totalNetRecents as $total_net_recent) 
    	{
    		$header = $this->block->getBlockValue($total_net_recent);
    		$content = $this->block->getBlockCollectionValue(
    			$total_net_recent->heatRecentHourly, 
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
