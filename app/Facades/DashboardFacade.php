<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class DashboardFacade extends Facade 
{
	protected static function getFacadeAccessor() 
	{
		return 'dashboardService';
	}
}

