<?php 

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
	protected $table = 'display.user_settings';

	public function user()
	{
		return $this->belongsTo('App\Entities\User', 'user_id');
	}
}