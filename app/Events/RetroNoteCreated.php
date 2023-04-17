<?php

namespace App\Events;

use App\Models\RetroNote;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RetroNoteCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $retroSessionId;
    private RetroNote $retroNote;

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

    public function broadcastAs()
    {
        return 'retro-note-created';
    }
}
