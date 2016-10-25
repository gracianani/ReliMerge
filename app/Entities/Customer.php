<?php 

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $table = 'customers';

	protected $primaryKey = 'ItemID';

	protected $timestamp = false;

}	