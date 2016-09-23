<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Station extends Model
{
    protected $table = 'Stations';

    protected $primaryKey = 'ItemID';

    public function company()
    {
    	return $this->belongsTo('App\Entities\Company');
    }

}
