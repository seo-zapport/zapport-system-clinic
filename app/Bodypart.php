<?php

namespace App;

class Bodypart extends Model
{
	public $timestamps = false;

    public function diseases()
    {
    	return $this->hasMany(Disease::class);
    }

    public function getRouteKeyName()
    {
    	return 'bodypart_slug';
    }
}
