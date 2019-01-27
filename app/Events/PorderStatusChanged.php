<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PorderStatusChanged extends Event
{
    use SerializesModels;

    public $porder_id;
    public $porder_status;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($porder_id, $porder_status)
    {
        $this->porder_id = $porder_id;
        $this->porder_status = $porder_status;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
