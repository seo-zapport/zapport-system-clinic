<?php

namespace App;

use Illuminate\Support\Carbon;

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
      return $this->belongsToMany(Medicine::class, 'employeesmedical_medicine_users', 'employeesmedical_id')->withPivot('quantity')->withTimestamps();
    }

    public function users()
    {
      return $this->belongsToMany(User::class, 'employeesmedical_medicine_users', 'employeesmedical_id')->withPivot('quantity')->withTimestamps();
    }

    public function setCreatedatAttribute($value) 
    {
        $this->attributes['created_at'] = (new Carbon($value))->format('Y-m-d H:i');
    }

    public function medNote()
    {
        return $this->belongsToMany(Mednote::class, 'employeesmedical_mednotes', 'employeesmedical_id');
    }

    public function diagnoses()
    {
        return $this->belongsTo(Diagnosis::class, 'diagnosis_id');
    }
}
