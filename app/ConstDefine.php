<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConstDefine extends Model
{
    const ACTIVE_AREA_NAME = '有效面积';
    const ACTIVE_AREA_UNIT = '㎡';
    const ACTIVE_STATIONS_NAME = '有效站个数';
    const ACTIVE_STATIONS_UNIT = '个';

    const HEAT_ID = 3;
    const HEAT_EAST_ID = 1;
    const HEAT_WEST_ID = 2;
}
