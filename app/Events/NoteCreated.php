<?php

namespace App\Events;

use App\Models\Note;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NoteCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $retroSessionId;
    private Note $note;

    /**
     * Create a new event instance.
     */
    public function __construct($retroSessionId, $note)
    {
        $this->retroSessionId = $retroSessionId;
        $this->note = $note;
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
            'note' => [...$this->note->toArray()],
        ];
    }

    public function broadcastAs()
    {
        return 'retro-note-created';
    }
}
