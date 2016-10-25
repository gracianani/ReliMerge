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

}
