<?php

namespace App;

class Supply extends Model
{
    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function supbrand()
    {
    	return $this->belongsTo(Supbrand::class, 'supbrand_id');
    }

    public function supgen()
    {
    	return $this->belongsTo(Supgen::class, 'supgen_id');
    }
}
