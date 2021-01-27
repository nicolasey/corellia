<?php
namespace Modules\Factions\Models;

use Illuminate\Database\Eloquent\Model;

class Assignation extends Model
{
    protected $table = "group_elements";
    protected $guarded = [];
    protected $hidden = ['group_id'];
    public $timestamps = false;
    protected $with = ['group'];

    /**
     * Filter to find leader of the group
     *
     * @param $query
     * @param bool $leader
     */
    public function scopeLeader($query, bool $leader)
    {
        $query->where('isLeader', $leader);
    }

    /**
     * Filter to find leader of the group
     *
     * @param $query
     * @param bool $main
     */
    public function scopeMain($query, bool $main)
    {
        $query->where('isLeader', $main);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function element()
    {
        return $this->morphTo("element");
    }
}
