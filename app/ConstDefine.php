<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConstDefine extends Model
{
	const GROUP_EAST = 'east';

	const EAST = 1;
	const WEST = 2;
	const TOTAL = 3;

	const EAST_NAME = '东部';
	const WEST_NAME = '西部';
	const TOTAL_NAME = '全网'; 


	const CURRENT_CONTROL_MODE = 1; // '设置当前控制方式，手动或自动';
	const CONTROL_MODE = 1; // '自动时，二次供温控制模式';

	const SUBLINE_SECOND_TEMPERATURE_OUT_CONTROLLED_BY_MANUAL = 0;
	const SUBLINE_SECOND_TEMPERATURE_OUT_CONTROLLED_BY_WEATHER_1 = 1;
	const SUBLINE_SECOND_TEMPERATURE_OUT_CONTROLLED_BY_WEATHER_2 = 2;
	const SUBLINE_SECOND_TEMPERATURE_OUT_CONTROLLED_BY_HOUR_1 = 3;
	const SUBLINE_SECOND_TEMPERATURE_OUT_CONTROLLED_BY_HOUR_2 = 4;
	const SUBLINE_SECOND_TEMPERATURE_OUT_CONTROLLED_BY_LOW_TEMP = 5;

	public static function getSecondTemperatureOutControlModeName($value)
	{
		switch($value)
		{
			case ConstDefine::SUBLINE_SECOND_TEMPERATURE_OUT_CONTROLLED_BY_MANUAL:
				return '手动控制模式';
			case ConstDefine::SUBLINE_SECOND_TEMPERATURE_OUT_CONTROLLED_BY_LOW_TEMP:
				return '低温运行模式';
			case ConstDefine::SUBLINE_SECOND_TEMPERATURE_OUT_CONTROLLED_BY_HOUR_2:
				return '时段控制曲线2';
			case ConstDefine::SUBLINE_SECOND_TEMPERATURE_OUT_CONTROLLED_BY_HOUR_1:
				return '时段控制曲线1';
			case ConstDefine::SUBLINE_SECOND_TEMPERATURE_OUT_CONTROLLED_BY_WEATHER_2:
				return '温度控制曲线2';
			case ConstDefine::SUBLINE_SECOND_TEMPERATURE_OUT_CONTROLLED_BY_WEATHER_1:
				return '温度控制曲线1';
		}
	}

	public static function getControlModeName($value)
	{
		switch ($value) {
			case '1':
				return '自动';
			case '2':
				return '手动';
		}
	}

	public static function getDistrictName($value)
	{
		switch ($value) {
			case ConstDefine::EAST:
				return '东部';
			case ConstDefine::WEST:
				return '西部';
			case ConstDefine::TOTAL:
				return '全网';
		}
	}

	public static function getRoleName($value)
	{
		switch ($value) {
			case 1:
				return '集团领导';
			case 2:
				return '生产部调度';
			case 3:
				return '分公司调度';
			case 4:
				return '中心调度';
		}
	}
}
