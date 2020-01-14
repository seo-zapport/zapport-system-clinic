<?php

namespace App;

class SupbrandSupgen extends Model
{
    public function supgens()
    {
    	return $this->hasMany(Supgen::class, 'supbrand_supgens', 'supbrand_id', 'supgen_id');
    }

    public function supbrands()
    {
    	return $this->hasMany(Supbrand::class, 'supbrand_supgens', 'supbrand_id', 'supgen_id');
    }
}
