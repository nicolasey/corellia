<?php

namespace Modules\Personnages\Traits;

trait DefaultAvatar
{
    private function getDefaultAvatarPath()
    {
        return resource_path("images/default-avatar.jpg");
    }

    public function setDefaultAvatar()
    {
        $current = $this->getFirstMediaUrl('avatar');
        if (!$current || $current === "") {
            $avatar = $this->getDefaultAvatarPath();
            $this->addMedia($avatar)->toMediaCollection('avatar');
        }
    }

    public static function bootDefaultAvatar()
    {
        static::created(function ($model) {
            $model->setDefaultAvatar();
        });

        static::updated(function ($model) {
            $model->setDefaultAvatar();
        });
    }
}
