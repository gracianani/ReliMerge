<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class StationAccumulate extends Model
{
    protected $table = 'StationAccuHistory';

    protected $primaryKey = 'ItemID';
}
