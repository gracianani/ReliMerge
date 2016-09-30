<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;


class TotalNetFacade extends Facade 
{
	protected static function getFacadeAccessor() 
	{
		return 'totalNetService';
	}
}