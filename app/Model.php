<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
	protected $guarded = ["id", "user_id", "role_id", "department_id", "position_id"];
	protected $dates = ["birthday", "created_at", "updated_at"];
}
