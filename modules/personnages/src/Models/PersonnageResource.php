<?php

namespace Modules\Personnages\Models;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonnageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'age' => $this->age,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'hide' => $this->hide,
            'current' => $this->current,
            'active' => $this->active,
            'isStaff' => $this->isStaff,
            'alive' => $this->alive,

            'job' => $this->job,
            'title' => $this->title,

            'bio' => $this->bio,
            'affections' => $this->affections,
            'aversions' => $this->aversions,
            'physical' => $this->physical,

            'avatar' => $this->setAvatar(),
            'faction' => $this->getFaction(),
            'assignations' => $this->assignations
        ];
    }

    /**
     * Return personnage's faction
     *
     * @return Group
     */
    public function getFaction()
    {
        return $this->assignations->filter(function ($item) {
            return $item->isMain;
        })->first()->group;
    }

    /**
     * For now avatar only returns "standard" version
     *
     * @return array
     */
    private function setAvatar()
    {
        $thumb = $this->getFirstMediaUrl('avatar');
        $thumb = ($thumb === "" || !$thumb) ? null : $thumb;
        return ['thumb' => $thumb];
    }
}
