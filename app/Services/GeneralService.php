<?php namespace App\Services;

use App\Entities\Block;
use App\ConstDefine;

class GeneralService
{
	public function getDistrictIdByDistrictName($value)
	{
		switch($value)
		{
			case ConstDefine::EAST_NAME :
				return ConstDefine::EAST;

			case ConstDefine::WEST_NAME :
				return ConstDefine::WEST;

			case ConstDefine::TOTAL_NAME :
				return ConstDefine::TOTAL;
		}
		return '';
	}
}