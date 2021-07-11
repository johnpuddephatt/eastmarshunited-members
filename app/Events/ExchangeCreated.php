<?php

namespace App\Events;

use App\Models\User;
use App\Models\Exchange;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExchangeCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $exchange;
    public $message;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Exchange $exchange, Message $message = null)
    {
        $this->exchange = $exchange;
        $this->message = $message ?? '';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('channel-name');
    }
}
