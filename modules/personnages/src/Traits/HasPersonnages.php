<?php
namespace Modules\Personnages\Traits;

use Modules\Personnages\Models\Personnage;

trait HasPersonnages
{
    /**
     * Model's personnages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personnages()
    {
        return $this->hasMany(Personnage::class, "owner_id");
    }

    public function activePersonnage()
    {
        return $this->personnages()->where("active", true);
    }
}