<?php

namespace App;

class Preemployment extends Model
{
    public function employee()
    {
    	return $this->belongsTo(Employee::class, 'employee_id');
    }
}