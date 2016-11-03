<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use ReliStations;
use ReliTotalNet;
use App\Extensions\ReliPaginator;
use App\User;
use ReliDashboard;

class StationBlock extends Model
{
    public $timestamps = false;

    public $table = 'station_blocks';
	
    public $filter_parameters = [];

    public $current_page = -1;

    public $per_page = -1;

    public $recent_data =[];

    public $search_parameter = '';

	public function block()
	{
		return $this->belongsTo('App\Entities\Block');
	}

    public function getTableHeaderBlockUnitArrayAttribute()
    {
        $header = $this->block->getHeaderBlockUnitArray('table_header_block_unit_array');
        
        return $header;
    }

	public function getStationsAttribute()
	{
        if(sizeof($this->filter_parameters) == 0)
        {
		  return ReliStations::fetchAll();
        }
        else {
            return ReliStations::filter($this->filter_parameters, $this->table_header_block_unit_array);
        }
	}

	public function getBlockArrayAttribute()
    {
        $header = $this->block->applyCustomSettings('table_header_block_unit_array');
        $properties = $this->block->applyCustomSettings('property');
        $multiplied = $this->stations->map(function ($item, $key) use ($properties) {
            $item->columns = $properties;
		    return $item->item_array;
		});

        $paginator = new ReliPaginator($multiplied, sizeof( $multiplied ), $this->per_page, $this->current_page);
    	
    	return array(
            "paginator" => $paginator->toPagingArray(),
    		"header" => $this->table_header_block_unit_array,
    		"content" => $paginator->getData()
    	);
    }

    public function getStationRecentByParametersBlockArrayAttribute()
    {
        $multiplied = $this->recent_data;
        $header = $this->block->getHeaderBlockUnitArray('static_header_block_unit_array');
        $appended = ReliDashboard::getHeader('station_recent', $this->search_parameter,'static_header_block_unit_array' );
        $header = $header->merge([ $appended ] );
        return array(
            "header" => $header,
            "content" => $multiplied
        );
    }

     
}