<?php

namespace Modules\Personnages\Events;

use Modules\Personnages\Models\Personnage;

class PersonnageKilled extends Event
{
    protected $name;
    public $personnage;

    public function __construct(Personnage $personnage)
    {
        $this->personnage = $personnage;
        $this->name = "personnage::killed";
    }

    public function broadcastOn()
    {
        //
    }
}
