<?php

namespace App;

class EmployeesmedicalMednote extends Model
{
    public function employeesMedical()
    {
        return $this->hasMany(Employeesmedical::class, 'employeesmedical_mednotes', 'employeesmedical_id', 'mednote_id');
    }

    public function medNote()
    {
        return $this->hasMany(Mednote::class, 'employeesmedical_mednotes', 'employeesmedical_id', 'mednote_id');
    }
}
