<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Entities\Block;
use Log;

class DashboardBlockUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public $block;

    public function __construct(Block $block)
    {
        $this->block = $block;
    }

    public function broadcastOn()
    {
        return new Channel('block.'.$this->block->id);
    }

    public function broadcastWith()
    {
        return 
            $this->block->block_array;
    }
}