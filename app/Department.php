<?php

namespace App;

class Department extends Model
{
    public function positions(){
    	return $this->belongsToMany(Position::class, 'department_positions', 'department_id');
    }

    public function employee()
    {
    	return $this->hasMany(Employee::class, 'department_id');
    }
}
