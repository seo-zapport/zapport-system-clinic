<?php

namespace App;

class Bodypart extends Model
{
	public $timestamps = false;

    public function diseases()
    {
    	return $this->hasMany(Disease::class);
    }
}
