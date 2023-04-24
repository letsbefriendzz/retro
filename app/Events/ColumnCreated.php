<?php

namespace App\Events;

use App\Http\Resources\ColumnResource;
use App\Models\Column;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ColumnCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $sessionId;
    private Column $column;

    public function __construct($sessionId, $column)
    {
        $this->sessionId = $sessionId;
        $this->column = $column;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel("retro-session-$this->sessionId"),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'column' => new ColumnResource($this->column),
        ];
    }

    public function broadcastAs(): string
    {
        return 'column-created';
    }
}
