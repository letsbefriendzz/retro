<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NoteDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $sessionId;
    private $noteId;

    /**
     * Create a new event instance.
     */
    public function __construct($sessionId, $noteId)
    {
        $this->sessionId = $sessionId;
        $this->noteId = $noteId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel("retro-session-{$this->sessionId}"),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'note' => [
                'id' => $this->noteId
            ],
        ];
    }

    public function broadcastAs()
    {
        return 'retro-note-deleted';
    }
}
