<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RetroNoteDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $retroSessionId;
    private $retroNoteId;

    /**
     * Create a new event instance.
     */
    public function __construct($retroSessionId, $retroNoteId)
    {
        $this->retroSessionId = $retroSessionId;
        $this->retroNoteId = $retroNoteId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel("retro-session-{$this->retroSessionId}"),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'note' => [
                'id' => $this->retroNoteId
            ],
        ];
    }

    public function broadcastAs()
    {
        return 'retro-note-deleted';
    }
}