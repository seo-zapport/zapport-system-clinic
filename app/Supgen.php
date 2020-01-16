<?php

namespace App;

class Supgen extends Model
{
    public function supbrands()
    {
    	return $this->belongsToMany(Supbrand::class, 'supbrand_supgens', 'supgen_id');
    }

    public function supplies()
    {
    	return $this->hasMany(Supply::class, 'supgen_id');
    }

    public function getRouteKeyName()
    {
    	return 'slug';
    }
}
