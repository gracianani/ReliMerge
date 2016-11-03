<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'display.users';

    protected $primaryKey = 'userId';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function settings()
    {
        return $this->hasMany('App\Entities\UserSetting', 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Entities\Role', 'membership.role_users')->withPivot('user_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo('App\Entities\Company', 'company_id');
    }

    public function getRoleIdsAttribute()
    {
        return $this->roles->map( function($item, $key) 
                {
                    return $item->id;
                })->values();
    }
}
