<?php

namespace App;

class EmployeesmedicalMedicine extends Model
{
    public function employeesMedical()
    {
        return $this->hasMany(Employeesmedical::class, 'employeesmedical_medicines', 'employeesmedical_id', 'medicine_id');
    }

    public function medicines()
    {
      return $this->hasMany(Medicine::class, 'employeesmedical_medicines', 'employeesmedical_id', 'medicine_id');
    }
}
