<?php

namespace App;

class DepartmentPosition extends Model
{
    public function positions()
    {
    	return $this->hasMany(Position::class, 'department_positions', 'department_id', 'position_id');
    }
    public function departments()
    {
    	return $this->hasMany(Department::class, 'department_positions', 'department_id', 'position_id');
    }
}
