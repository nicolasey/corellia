<?php

namespace Modules\Personnages\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Event implements ShouldBroadcast
{
    use SerializesModels;
    use InteractsWithSockets;
    use Dispatchable;

    protected $name;

    public function broadcastAs()
    {
        return $this->name;
    }

    public function broadcastOn()
    {
        // must be extended by real events
    }
}
