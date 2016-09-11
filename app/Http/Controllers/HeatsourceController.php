<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Entities\Heatsource;

class HeatsourceController extends Controller
{
    public function showBasic()
    {
    	$heatsource = HeatSource::where("ItemId",7)->first();
    	return view('heatsource.index')
    		->with('heatsource',$heatsource);
    }
}
