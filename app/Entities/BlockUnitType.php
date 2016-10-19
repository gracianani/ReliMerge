<?php 

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class BlockUnitType extends Model
{
	protected $table = 'block_block_units';

	const HEADER = 1;
	const CONTENT = 2;

	public function blockUnit()
	{
		return $this->hasOne('App\Entities\BlockUnit');
	}
}

