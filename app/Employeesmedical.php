<?php

namespace App;

class Employeesmedical extends Model
{
    public function employee()
    {
      return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function medicines()
    {
      return $this->belongsToMany(Medicine::class, 'employeesmedical_medicines', 'employeesmedical_id');
    }
}
