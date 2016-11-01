<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use ReliHeatsources;
use Exception;
use ReliDashboard;
use Validator;

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
        $data = array_merge($data, ["id"=>$id]);
        $validator = Validator::make(
            $data , 
            ReliHeatsources::getValidationRules(), 
            ReliHeatsources::getValidationMessages()
        );

        if ($validator->fails()) {
            return response()->json(
                array( 'error' => true,
                'error_message' => $validator->errors())
            );
        }
        $result = ReliHeatsources::update($id, $data);

        $heatsource = ReliHeatsources::fetch($id);
        return response()->json(
            array( 'error' => !$result, 
            "heatsource" => $heatsource->heat_source_array )

        );
    }

    public function batchUpdate(Request $request)
    {
        $data = json_decode( $request->input('data'), true);
        foreach($data as $data_item)
        {
            $validator = Validator::make(
                $data_item , ReliHeatsources::getValidationRules(), ReliHeatsources::getValidationMessages() );
            if ($validator->fails()) {
                return response()->json(
                    array( 'error' => true,
                    'error_message' => $validator->errors())
                );
            }
        }
        $result = ReliHeatsources::batchUpdate($data);
        $ids = array_column($data, 'id');
        return response()->json(
            array( 'error' => !$result,
                "heat_sources" => ReliHeatsources::fetch($ids)->map(function($item)
                {
                    return $item->heat_source_array;
                })
            )
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
        $block = ReliDashboard::getBlock('heatsource_recent');
        return response()->json(
            $block->getByParameter($id, $parameter)
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
