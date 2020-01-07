<?php

namespace App;

class Diagnosis extends Model
{
	public $timestamps = false;
	
    public function employeesMedicals()
    {
    	return $this->hasMany(Employeesmedical::class);
    }

    public function diseases()
    {
    	return $this->belongsTo(Disease::class, 'disease_id');
    }
}
