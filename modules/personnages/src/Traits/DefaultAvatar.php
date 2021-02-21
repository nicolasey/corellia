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
        $current = $this->getFirstMediaUrl();
        if (!$current || $current === "") {
            $url = env("APP_URL") . "/default-avatar.jpg";
            $this->addMediaFromUrl($url)->toMediaCollection('avatar');
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
