<?php

namespace App;

class Medicine extends Model
{
    public function medBrand()
    {
    	return $this->belongsTo(Medbrand::class, 'brand_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
