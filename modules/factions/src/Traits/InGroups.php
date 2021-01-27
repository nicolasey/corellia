<?php
namespace Modules\Factions\Traits;

use Modules\Factions\Models\Assignation;
use Modules\Factions\Models\Group;

trait InGroups
{
    /**
     * Get object groups
     *
     * @return mixed
     */
    public function assignations()
    {
        return $this->morphMany(Assignation::class, 'element');
    }
}
