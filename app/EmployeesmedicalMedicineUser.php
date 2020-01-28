<?php

namespace App;

use Carbon\Carbon;

class EmployeesmedicalMedicineUser extends Model
{
    public function employeesMedical()
    {
        return $this->hasMany(Employeesmedical::class, 'employeesmedical_medicine_users', 'employeesmedical_id', 'medicine_id', 'user_id')->withPivot('quantity')->withTimestamps();
    }

    public function medicines()
    {
      	return $this->hasMany(Medicine::class, 'employeesmedical_medicine_users', 'employeesmedical_id', 'medicine_id', 'user_id')->withPivot('quantity')->withTimestamps();
    }

    public function users()
    {
      	return $this->hasMany(User::class, 'employeesmedical_medicine_users', 'employeesmedical_id', 'medicine_id', 'user_id')->withPivot('quantity')->withTimestamps();
    }

    // public function setCreatedatAttribute($value) 
    // {
    //     $this->attributes['created_at'] = (new Carbon($value))->format('Y-m-d H:i');
    // }
}
