<?php

namespace App;

class MediaPost extends Model
{
    public function medias()
    {
    	return $this->hasMany(Media::class, 'media_posts', 'media_id', 'post_id');
    }

    public function posts()
    {
    	return $this->hasMany(Post::class, 'media_posts', 'media_id', 'post_id');
    }
}
