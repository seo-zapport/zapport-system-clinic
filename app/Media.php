<?php

namespace App;

class Media extends Model
{
    public function posts()
    {
    	return $this->belongsToMany(Post::class);
    }

    public function users()
    {
    	return $this->belongsTo(User::class);
    }
}
