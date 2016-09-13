<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Entities\Heatsource;
use App\Entities\Block;

class HeatsourceController extends Controller
{
    public function show()
    {
    	$heatsource = HeatSource::find(7)->first();
    	return view('heatsource.index')
    		->with('heatsource',$heatsource);
    }


    public function showBasic()
    {
        $block = Block::where('module', 'heatsource')->first();
        $heatsource_block = $block->blockable;
        return response()->json(
            $heatsource_block->block_array
        );
    }
}
