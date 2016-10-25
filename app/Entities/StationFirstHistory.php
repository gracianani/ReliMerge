<?php 

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class StationFirstHistory extends Model
{
	protected $table = 'Station1stHistory';

	protected $primaryKey = 'ItemID';

	protected $timestamps = false;

	public function station()
	{
		return $this->belongsTo('App\Entities\Station');
	}

}