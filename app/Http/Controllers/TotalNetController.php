<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use ReliDashboard;

class TotalNetController extends Controller
{
 	public function showStatByTotalNet(Request $request)
    {
        $block = ReliDashboard::getBlock('totalnet_stat');

        $district_ids = json_decode( $request->input('district_ids'), true);
        $from = $request->input('from');
        $to = $request->input('to');

        return response()->json(
            $block->getTotalNetStatPerDay(
                $district_ids,
                $from, 
				$to            
			)
        );
    }
}