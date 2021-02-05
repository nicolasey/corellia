<?php

namespace Modules\Factions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Factions\Factories\GroupFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Group extends Model implements HasMedia
{
    use SoftDeletes;
    use HasSlug;
    use InteractsWithMedia;
    use HasFactory;

    protected $table = "groups";
    protected $guarded = [];

    protected static function factory()
    {
        return GroupFactory::new();
    }

    /**
     * Register media collections for the personnage
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    /**
     * Filter secret groups
     *
     * @param bool $isSecret
     * @return mixed
     */
    public function scopeSecret($query, bool $isSecret)
    {
        return $query->where('isSecret', $isSecret);
    }

    /**
     * Keeps only factions, and no groups
     *
     * @param bool $isFaction
     * @return mixed
     */
    public function scopeFaction($query, bool $isFaction)
    {
        return $query->where('isFaction', $isFaction);
    }

    /**
     * Get the options for generating the slug.
     *
     * @return mixed
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
