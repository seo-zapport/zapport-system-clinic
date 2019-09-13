<?php

namespace App;

class Medbrand extends Model
{
    public $timestamps = false;

    public function medicines()
    {
    	return $this->hasMany(Medicine::class, 'brand_id');
    }

    public function generic()
    {
    	return $this->belongsToMany(Generic::class, 'medbrand_generics', 'medbrand_id');
    }

    public function getRouteKeyName()
    {
        return 'bname';
    }
}
