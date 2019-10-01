<?php

namespace App;

class Tag extends Model
{
    public function posts()
    {
    	return $this->belongsToMany(Post::class, 'post_tags', 'tag_id');
    }

    public function getRouteKeyName()
    {
    	return 'tag_name';
    }
}
