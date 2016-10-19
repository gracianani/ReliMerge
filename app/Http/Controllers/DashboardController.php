<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Entities\Block;

use ReliDashboard;

class DashboardController extends Controller
{
    public function show()
    {
    	$blocks = ReliDashboard::getBlocks('dashboard');

    	$multiplied = $blocks->map(function ($item, $key) {
		    return $item->block_array;
		});

    	return response()->json(
			array(
				"blocks" => $multiplied
			)
    	);
    }

    public function showStationInfo( $station_id )
    {
        $blocks = ReliDashboard::getBlocks('station_dashboard' );

        $multiplied = $blocks->map(function ($item, $key) use($station_id) {
            $item->station_id = $station_id;
            return $item->block_array;
        });

        return response()->json(
            array(
                "blocks" => $multiplied
            )
        );
    }
}

