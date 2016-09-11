<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Entities\Block;

class DashboardController extends Controller
{
    public function show()
    {
    	$blocks = Blocks::all();
    	return response()->json(
			$blocks->lists('block_array')
    	);
    }
}


