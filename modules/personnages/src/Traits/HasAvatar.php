<?php

namespace Modules\Personnages\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasAvatar
{
    /**
     * Register media collections for the personnage
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(100)
              ->height(100)
              ->sharpen(10);
    }

    public function getAvatarAttribute()
    {
        $original = $this->getMedia('avatar')->first()->getUrl();
        $thumb = $this->getMedia('avatar')->first()->getUrl('thumb');
        return compact($original, $thumb);
    }
}
