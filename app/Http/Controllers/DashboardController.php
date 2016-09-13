<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Entities\Block;

class DashboardController extends Controller
{
    public function show()
    {
    	$blocks = Block::where('module', 'dashboard')->get();

    	$multiplied = $blocks->map(function ($item, $key) {
		    return $item->block_array;
		});

    	return response()->json(
			array(
				"blocks" => $multiplied
			)
    	);
    }
}

