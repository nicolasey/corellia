<?php

namespace Modules\Personnages\Traits;

trait HasAvatar
{
    public function getAvatarAttribute()
    {
        $original = $this->getMedia('avatar')->first()->getUrl();
        $thumb = $this->getMedia('avatar')->first()->getUrl('thumb');
        return compact('original', 'thumb');
    }
}
