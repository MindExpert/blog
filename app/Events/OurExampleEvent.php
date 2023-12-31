<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OurExampleEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public mixed $username;
    public mixed $action;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($theEvent)
    {
        $this->username = $theEvent['username'];
        $this->action   = $theEvent['action'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|PrivateChannel|array
     */
    public function broadcastOn(): Channel|PrivateChannel|array
    {
        return new PrivateChannel('channel-name');
    }
}
