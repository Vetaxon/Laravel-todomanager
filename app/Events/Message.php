<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Auth;

class Message implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $message;
   
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {        
        return new PrivateChannel('room.' . $this->message['room_id']);
    }
}
