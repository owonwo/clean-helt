<?php

namespace App\Events;

use App\Models\Patient;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProfileExpirationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $patient;
    public $provider;

    /**
     * Create a new event instance.
     *
     * @param Patient $patient
     * @param $provider
     */
    public function __construct(Patient $patient, $provider)
    {
            $this->provider = $provider;
            $this->patient = $patient;
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
