<?php

namespace App;

class MedbrandGeneric extends Model
{
    public function medBrans()
    {
    	return $this->hasMany(Medbrand::class, 'medbrand_generics', 'medbrand_id', 'generic_id');
    }
    
    public function generics()
    {
    	return $this->hasMany(Generic::class, 'medbrand_generics', 'medbrand_id', 'generic_id');
    }
}
