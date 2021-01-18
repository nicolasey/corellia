<?php
namespace Modules\Forum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Personnages\Models\Personnage;

class Post extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function author()
    {
        return $this->belongsTo(Personnage::class, "author_id");
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->topic->author->owner->follow($model);
        });
    }
}
