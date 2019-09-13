<?php

namespace App;

class EmployeesmedicalMedicine extends Model
{
    public function employeesMedical()
    {
        return $this->hasMany(Employeesmedical::class, 'employeesmedical_medicines', 'employeesmedical_id', 'medicine_id')->withPivot('quantity')->withTimestamps();
    }

    public function medicines()
    {
      	return $this->hasMany(Medicine::class, 'employeesmedical_medicines', 'employeesmedical_id', 'medicine_id')->withPivot('quantity')->withTimestamps();
    }

    public function users()
    {
      	return $this->hasMany(User::class, 'employeesmedical_medicines', 'employeesmedical_id', 'medicine_id')->withPivot('quantity')->withTimestamps();
    }
}
