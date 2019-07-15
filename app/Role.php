<?php

namespace App;

class Role extends Model
{
	public $timestamps = false;
    
    public function users()
    {
    	return $this->belongsToMany(User::class, 'user_roles', 'role_id');
    }

    public function user_roles()
    {
    	return $this->belongsToMany(User_role::class, 'user_roles', 'use_id', 'role_id');
    }

}
