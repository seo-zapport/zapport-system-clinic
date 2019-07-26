<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
	protected $guarded = [
		"id", 
		"user_id", 
		"role_id", 
		"department_id", 
		"position_id",
		"brand_id",
		"generic_id",
		"medbrand_id",
		"medicine_id",
];
	protected $dates = [
		"birthday", 
		"created_at", 
		"updated_at", 
		"elementary_grad_date", 
		"highschool_grad_date", 
		"college_grad_date", 
		"father_birthday", 
		"mother_birthday", 
		"date_of_merriage",
		"expiration_date",
	];
}
