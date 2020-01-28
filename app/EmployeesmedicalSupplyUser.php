<?php

namespace App;

class EmployeesmedicalSupplyUser extends Model
{
    public function employeesMedical()
    {
        return $this->hasMany(Employeesmedical::class, 'employeesmedical_supply_users', 'employeesmedical_id', 'supply_id', 'user_id')->withPivot('supqty')->withTimestamps();
    }

    public function supplies()
    {
      	return $this->hasMany(Supply::class, 'employeesmedical_supply_users', 'employeesmedical_id', 'supply_id', 'user_id')->withPivot('supqty')->withTimestamps();
    }

    public function users()
    {
      	return $this->hasMany(User::class, 'employeesmedical_supply_users', 'employeesmedical_id', 'supply_id', 'user_id')->withPivot('supqty')->withTimestamps();
    }
}
