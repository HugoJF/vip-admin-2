<?php

namespace App\Events;

use App\Token;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewAffiliateToken
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $token;

	/**
	 * Create a new event instance.
	 *
	 * @param Token $token
	 */
    public function __construct(Token $token)
    {
    	$this->token = $token;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
