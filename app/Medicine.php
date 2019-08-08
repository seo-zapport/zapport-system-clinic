<?php

namespace App;

use Carbon\Carbon;

class Medicine extends Model
{
    public function medBrand()
    {
    	return $this->belongsTo(Medbrand::class, 'brand_id');
    }

    public function generic()
    {
    	return $this->belongsTo(Generic::class, 'generic_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function employeesMedical()
    {
        return $this->belongsToMany(Employeesmedical::class, 'employeesmedical_medicine_users', 'medicine_id')->withPivot('quantity')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'employeesmedical_medicine_users', 'medicine_id')->withPivot('quantity')->withTimestamps();
    }

    public function setCreatedatAttribute($value) 
    {
        $this->attributes['created_at'] = (new Carbon($value))->format('Y-m-d H');
    }
}
