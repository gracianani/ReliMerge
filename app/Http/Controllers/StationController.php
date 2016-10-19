<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use ReliStations;
use ReliDashboard;
use Exception;

class StationController extends Controller
{
	public function showBasic()
    {
        $block = ReliDashboard::getBlock('station');
        return response()->json(
            $block->block_array
        );
    }

    public function showRealtime()
    {
    	$block = ReliDashboard::getBlock('station_recent');
        return response()->json(
            $block->station_recent_block_array
        );
    }

}