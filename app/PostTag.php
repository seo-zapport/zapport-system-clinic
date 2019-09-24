<?php

namespace App;

class PostTag extends Model
{
    public function posts()
    {
    	return $this->belongsToMany(Post::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function tags()
    {
    	return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }
}
