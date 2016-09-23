<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use ReliHeatsources;

class HeatsourceController extends Controller
{
    public function showBasic()
    {
        $block = ReliHeatsources::getBlock('heatsource');
        return response()->json(
            $block->block_array
        );
    }

    public function updateBasic()
    {

    }

    public function batchUpdateBasic()
    {

    }

    public function showRealtime()
    {
        $block = ReliHeatsources::getBlock('heatsource_recent');
        return response()->json(
            $block->heatsource_recent_block_array
        );
    }

    public function showRealtimeByParameter()
    {

    }

    public function showStat()
    {

        $block = ReliHeatsources::getBlock('heatsource_stat');

        return response()->json(
            $block->getHeatsourceStatPerDay(
                array( 7, 17 , 22, 18),
                '2015-11-5', '2015-11-8'
            )
        );
    }

    public function showStatByGroup()
    {

    }


} 
