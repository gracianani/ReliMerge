<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use ReliStations;
use ReliDashboard;
use Exception;

class StationController extends Controller
{
	public function showBasic( Request $request )
    {
        $block = ReliDashboard::getBlock('station');
        $block->filter_parameters = json_decode ($request->input('parameters'), true);
        $block->current_page = $request->input('current_page', -1);
        $block->per_page = $request->input('per_page', -1);
        
        return response()->json(
            $block->block_array
        );
    }

    public function showRealtime( Request $request )
    {
    	$block = ReliDashboard::getBlock('station_recent');
        $block->filter_parameters = json_decode ($request->input('parameters'), true);
        $block->current_page = $request->input('current_page', -1);
        $block->per_page = $request->input('per_page', -1);
        return response()->json(
            $block->station_recent_block_array
        );
    }

    public function showRealtimeByParameter( $id, $parameter)
    {
        $block = ReliDashboard::getBlock('station_recent');
        return response()->json(
            $block->getByParameter($id, $parameter)
        );
    }

    public function updateControlParameters( Request $request, $station_id, $subline_num)
    {
        $station = ReliStations::fetch($station_id);
        $subline = ReliStations::fetchSublineBySublineNum($station_id, $subline_num);
        $data =  json_decode( $request->input('data'), true);
        ReliStations::updateControl( $station, $subline, $data);

        return response()->json(
            array(
                "station" => $station->station_array
            )
        );
    }

    public function filter( Request $request )
    {
        $block = ReliDashboard::getBlock('station');
        $block->filter_parameters = json_decode ($request->input('parameters'), true);
        
        return response()->json(
            $block->block_array
        );
    }

    public function getRealtimeParameters( Request $request, $station_id, $subline_num, $parameter)
    {
        $block = ReliDashboard::getBlock('station_recent_by_parameter');
        $station = ReliStations::fetch($station_id);
        $parameters = array(
            'station_id'=> 'int',
            'subline_num' => 'string',
            'time' => 'string'
        );
        $parameters = array_add($parameters, $parameter, 'float' );
        $arguments = array(
            'station_id' => $station_id,
            'subline_num' => $subline_num,
            'from' => $request->input('from'),
            'to' => $request->input('to'),
        );
        
        $result = $station->getRealtimeParameters( $parameters ,$arguments);
        $block->recent_data = $result;
        $block->search_parameter = $parameter;

        return response()->json(
            $block->station_recent_by_parameters_block_array
        );
    }
}