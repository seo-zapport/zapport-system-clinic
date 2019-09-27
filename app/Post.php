<?php

namespace App;

class Post extends Model
{
    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function tags()
    {
    	return $this->belongsToMany(Tag::class, 'post_tags', 'post_id');
    }

    public function medias()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function getRouteKeyName()
    {
    	return 'slug';
    }
}
