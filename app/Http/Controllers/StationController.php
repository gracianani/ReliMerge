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
}