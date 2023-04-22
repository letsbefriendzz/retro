<?php

namespace Tests\Feature\Models;

use App\Models\Note;
use App\Models\RetroSession;
use Tests\TestCase;

class RetroSessionTest extends TestCase
{
    public function test_it_has_many_retro_notes()
    {
        $retroSession = RetroSession::factory()->create();
        $note1 = Note::factory()->create([
            'retro_session_id' => $retroSession->id,
        ]);
        $note2 = Note::factory()->create([
            'retro_session_id' => $retroSession->id,
        ]);

        $this->assertCount(2, $retroSession->fresh()->notes);
        $this->assertTrue($retroSession->notes->contains($note1));
        $this->assertTrue($retroSession->notes->contains($note2));
    }
}
