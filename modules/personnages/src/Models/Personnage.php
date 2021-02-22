<?php

namespace Modules\Personnages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Factions\Traits\InGroups;
use Modules\Forum\Traits\PostsInForum;
use Modules\Personnages\Events\PersonnageCreated;
use Modules\Personnages\Events\PersonnageDeleted;
use Modules\Personnages\Events\PersonnageUpdated;
use Modules\Personnages\Traits\DefaultAvatar;
use Overtrue\LaravelFollow\Followable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Personnage extends Model implements HasMedia
{
    use SoftDeletes;
    use HasSlug;
    use InteractsWithMedia;
    use PostsInForum;
    use Followable;
    use HasFactory;
    use InGroups;
    use DefaultAvatar;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['alive', 'owner_id'];

    protected $hidden = ["deleted_at"];

    protected $with = ['assignations'];

    public static $rules = [
        "name" => "unique:personnages|min:3|required",
        "owner" => "required",
    ];

    protected $dispatchesEvents = [
        "created" => PersonnageCreated::class,
        "updated" => PersonnageUpdated::class,
        "deleted" => PersonnageDeleted::class,
    ];

    /** @return \Modules\Personnages\Factories\PersonnageFactory */
    protected static function newFactory()
    {
        return \Modules\Personnages\Factories\PersonnageFactory::new();
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

    public function resolveRouteBinding($value, $field = null)
    {
        if (is_numeric($value)) {
            return parent::resolveRouteBinding($value);
        } elseif (is_string($value)) {
            return $this->where('slug', $value)->firstOrFail();
        }

        return parent::resolveRouteBinding($value, $field);
    }

    /**
     * User this personnage is owned by
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(config("personnages.owner.class"), "owner_id");
    }

    /**
     * Filter staff from casual personnages
     *
     * @param $query
     * @param boolean $bool
     * @return mixed
     */
    public function scopeStaff($query, $bool)
    {
        return $query->where('isStaff', $bool);
    }

    /**
     * Filter active personnages
     *
     * @param $query
     * @param boolean $bool
     * @return mixed
     */
    public function scopeActive($query, $bool)
    {
        return $query->where('active', $bool);
    }

    /**
     * Select by owner
     *
     * @param $query
     * @param $id
     * @return mixed
     */
    public function scopeOf($query, $id)
    {
        return $query->where('owner_id', $id);
    }

    /**
     * Set active to this personnage as given boolean
     *
     * @param bool $isCurrent
     * @throws \Exception
     */
    public function setCurrent(bool $isCurrent)
    {
        try {
            $this->current = $isCurrent;
            $this->save();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Register media collections for the personnage
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')->width(100)->height(100);
            });
    }

    public function faction()
    {
        $assignations = $this->assignations()->where(["isMain" => true]);
        // if ($assignations !== []) {
        //     $assignations->filter(function ($item) {
        //         return ($item->isMain && $item->group->isFaction && !$item->group->isSecret);
        //     })->first()->group;
        // }
        return $assignations;
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            if ($model->owner) {
                $personnages = $model->owner->personnages;

                foreach ($personnages as $personnage) {
                    $personnage->setCurrent(false);
                }

                $model->setCurrent(true);
            }
        });
    }
}
