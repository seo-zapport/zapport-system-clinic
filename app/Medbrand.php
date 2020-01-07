<?php

namespace App;

class Medbrand extends Model
{
    public $timestamps = false;

    public function medicines()
    {
    	return $this->hasMany(Medicine::class, 'brand_id');
    }
}
