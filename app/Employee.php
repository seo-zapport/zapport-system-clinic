<?php

namespace App;

use Carbon\Carbon;

class Employee extends Model
{
    public function positions()
    {
    	return $this->belongsTo(Position::class, 'position_id');
    }

    public function departments()
    {
    	return $this->belongsTo(Department::class, 'department_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['birthday'])->age;
    }

    public function employeesMedical()
    {
        return $this->hasMany(Employeesmedical::class, 'employee_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getRouteKeyName()
    {
        return 'emp_id';
    }
}
