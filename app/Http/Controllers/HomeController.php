<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ReliDashboard;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }


    public function saveSettings(Request $request, $module)
    {
        $data = json_decode( $request->input('data'), true );
        $result = ReliDashboard::validate($data);
        $user = $request->user();
        if($result["error"])
        {
            return response()->json(
                $result
            );
        }
        else {
            ReliDashboard::saveSettings($module, $data, $user );
        }
        return response()->json(
            $user->settings->where('module_name' , $module)->first()
        );

    }

}
