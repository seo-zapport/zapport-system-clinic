<?php

namespace App;

class Disease extends Model
{
	public $timestamps = false;

    public function bodypart()
    {
    	return $this->belongsTo(Bodypart::class);
    }

    public function diagnoses()
    {
    	return $this->hasMany(Diagnosis::class);
    }
}
