<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use ReliHeatsources;
use Exception;
use ReliDashboard;

class HeatsourceController extends Controller
{
    public function showBasic()
    {
        $block = ReliDashboard::getBlock('heatsource');
        return response()->json(
            $block->block_array
        );
    }

    public function update(Request $request, $id)
    {
        $data = json_decode( $request->input('data'), true);
        $result = ReliHeatsources::update($id, $data);
        return response()->json(
            array( 'error' => !$result )
        );
    }

    public function batchUpdate(Request $request)
    {
        $data = json_decode( $request->input('data'), true);
        $result = ReliHeatsources::batchUpdate($data);
        return response()->json(
            array( 'error' => !$result )
        );
    }

    public function showRealtime()
    {
        $block = ReliDashboard::getBlock('heatsource_recent');
        return response()->json(
            $block->heatsource_recent_block_array
        );
    }

    public function showRealtimeByParameter( $id, $parameter)
    {
        $data = ReliHeatsources::fetchRealtimeByParameter($id, $parameter);
        return response()->json(
            $data
        );
    }

    public function showStatByHeatSource(Request $request)
    {
        $block = ReliDashboard::getBlock('heatsource_stat');

        $heatsource_ids = json_decode( $request->input('heatsource_ids'), true);
        $from = $request->input('from');
        $to = $request->input('to');


        return response()->json(
            $block->getHeatsourceStatPerDay(
                $heatsource_ids,
                $from, 
                $to
            )
        );
    }
   
} 
