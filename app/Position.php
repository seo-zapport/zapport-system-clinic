<?php

namespace App;

class Position extends Model
{
    public function departments()
    {
    	return $this->belongsToMany(Department::class, 'department_positions', 'position_id');
    }

    public function employee()
    {
    	return $this->hasMany(Employee::class, 'position_id');
    }
}
