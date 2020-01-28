<?php

namespace App;

class Supply extends Model
{
    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function supbrand()
    {
    	return $this->belongsTo(Supbrand::class, 'supbrand_id');
    }

    public function supgen()
    {
    	return $this->belongsTo(Supgen::class, 'supgen_id');
    }

    public function supUsers()
    {
        return $this->belongsToMany(User::class, 'employeesmedical_supply_users', 'supply_id')->withPivot('supqty')->withTimestamps();
    }

    public function supEmployeesMedicals()
    {
        return $this->belongsToMany(Employeesmedical::class, 'employeesmedical_supply_users', 'supply_id')->withPivot('supqty')->withTimestamps();
    }
}
