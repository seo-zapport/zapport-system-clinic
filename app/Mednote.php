<?php

namespace App;

class Mednote extends Model
{
    public function employeesMedical()
    {
        return $this->belongsToMany(Employeesmedical::class, 'employeesmedical_mednotes', 'mednote_id');
    }
}
