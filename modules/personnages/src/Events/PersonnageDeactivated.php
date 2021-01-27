<?php
namespace Modules\Personnages\Events;

use Modules\Personnages\Models\Personnage;

class PersonnageDeactivated extends Event
{
    protected $name;
    public $personnage;

    public function __construct(Personnage $personnage)
    {
        $this->personnage = $personnage;
        $this->name = "personnage.".$personnage->id.".deactivated";
    }

    public function broadcastOn()
    {

    }
}