<?php

namespace Tests\Feature\Models;

use App\Models\Note;
use App\Models\RetroSession;
use Tests\TestCase;

class NoteTest extends TestCase
{
    public function test_it_belongs_to_a_retro_session()
    {
        $retroSession = RetroSession::factory()->create();
        $note = Note::factory()->create([
            'retro_session_id' => $retroSession->id,
        ]);

        $this->assertInstanceOf(RetroSession::class, $note->retroSession);
        $this->assertEquals($retroSession->id, $note->retroSession->id);
    }
}
