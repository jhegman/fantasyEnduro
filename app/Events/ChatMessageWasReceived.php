<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatMessageWasReceived implements ShouldBroadcast  
{
    use InteractsWithSockets, SerializesModels;

    public $chatMessage;
    public $user;
    public $league_id;

    /**
     * Create a new event instance.
     *
     * @param $chatMessage
     * @param $user
     */
    public function __construct($chatMessage, $user, $league_id)
    {
        $this->chatMessage = $chatMessage;
        $this->user = $user;
        $this->league_id = $league_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('publicLeague.'.$this->league_id);
    }
}