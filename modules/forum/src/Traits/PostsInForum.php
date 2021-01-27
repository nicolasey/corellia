<?php
namespace Modules\Forum\Traits;

use Modules\Forum\Models\Post;
use Modules\Forum\Models\Topic;

trait PostsInForum
{
    public function topics()
    {
        return $this->hasMany(Topic::class, "author");
    }

    public function nbTopics()
    {
        return $this->topics()->count();
    }

    /**
     * User's posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, "author");
    }

    /**
     * User posts nb
     *
     * @return int
     */
    public function nbPosts()
    {
        return $this->posts()->count();
    }
}