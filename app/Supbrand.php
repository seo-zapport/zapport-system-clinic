<?php

namespace App;

class Supbrand extends Model
{
    public function supgens()
    {
    	return $this->belongsToMany(Supgen::class, 'supbrand_supgens', 'supbrand_id');
    }

    public function supplies()
    {
    	return $this->hasMany(Supply::class, 'supbrand_id');
    }

    public function getRouteKeyName()
    {
    	return 'slug';
    }
}
