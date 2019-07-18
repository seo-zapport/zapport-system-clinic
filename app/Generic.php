<?php

namespace App;

class Generic extends Model
{
	public $timestamps = false;
	
    public function medbrand()
    {
    	return $this->belongsToMany(Medbrand::class, 'medbrand_generics', 'generic_id');
    }

    public function medicines()
    {
    	return $this->hasMany(Medicine::class, 'brand_id');
    }
}
