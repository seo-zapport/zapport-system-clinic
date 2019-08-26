<?php

namespace App;

class Post extends Model
{
    public function employee()
    {
    	return $this->belongsTo(Employee::class);
    }
}
