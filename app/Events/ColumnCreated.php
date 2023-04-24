<?php

namespace App\Events;

use App\Http\Resources\ColumnResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ColumnCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct($sessionId, $column)
    {
        $this->sessionId = $sessionId;
        $this->column = $column;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel("retro-session-{$this->sessionId}"),
        ];
    }

    public function broadcastWith()
    {
        return [
            'column' => new ColumnResource($this->column),
        ];
    }

    public function broadcastAs()
    {
        return 'column-created';
    }
}
