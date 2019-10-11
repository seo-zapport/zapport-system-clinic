<?php

namespace App;

class Diagnosis extends Model
{
	public $timestamps = false;
	
    public function employeesMedicals()
    {
    	return $this->hasMany(Employeesmedical::class);
    }
}
