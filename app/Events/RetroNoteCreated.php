<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RetroNoteCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $retroSessionId;
    private $retroNote;

    /**
     * Create a new event instance.
     */
    public function __construct($retroSessionId, $retroNote)
    {
        $this->retroSessionId = $retroSessionId;
        $this->retroNote = $retroNote;
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
            'note' => $this->retroNote,
        ];
    }
}
