<?php

namespace App\Events;

use App\Admin;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AdminCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
	/**
	 * @var Admin
	 */
	public $admin;

	/**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Admin $admin)
    {
    	$this->admin = $admin;
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
