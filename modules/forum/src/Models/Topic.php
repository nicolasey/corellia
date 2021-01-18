<?php
namespace Modules\Forum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Personnages\Models\Personnage;
use Overtrue\LaravelFollow\Traits\CanBeFollowed;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Topic extends Model
{
    use SoftDeletes, HasSlug, CanBeFollowed;

    protected $guarded = [];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function author()
    {
        return $this->belongsTo(Personnage::class, "author_id");
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function lastPost()
    {
        return $this->posts()->latest("created_at");
    }

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            $model->posts()->delete();
        });

        static::created(function ($model) {
            $model->author->owner->follow($model);
        });
    }
}
