<?php

namespace App;

class User_role extends Model
{
    
	public function users()
	{
		return $this->belongsToMany(User::class , 'user_roles', 'user_id', 'role_id');
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class , 'user_roles', 'user_id', 'role_id');
	}

}
