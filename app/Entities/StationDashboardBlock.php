<?php 

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use ReliStations;

class StationDashboardBlock extends Model
{
	protected $table = 'station_dashboard_blocks';

    public $timestamps = false;

    private $station_id;

    public function getStationIdAttribute()
    {
    	return $station_id;
    }

    public function setStationIdAttribute( $value )
    {
    	$station_id = $value;
    }

    public function getStationAttribute()
    {
    	return ReliStations::find($this->station_id);
    }

    protected $dates = [
        'from',
        'to',
    ];

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