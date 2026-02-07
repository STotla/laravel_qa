<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class TestBroadcast implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $payload;

    public function __construct($payload = [])
    {
        $this->payload = $payload;
    }

    public function broadcastOn()
    {
        return new Channel('test'); // use PrivateChannel for auth testing later
    }

    public function broadcastWith()
    {
        return ['payload' => $this->payload];
    }

    public function broadcastAs()
    {
        return 'TestBroadcast';
    }
}