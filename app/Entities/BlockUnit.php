<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class BlockUnit extends Model
{
	public function blocks()
    {
        return $this->belongsToMany('App\Entities\Block');
    }
}
