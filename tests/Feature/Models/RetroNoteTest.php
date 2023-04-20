<?php

namespace Tests\Feature\Models;

use App\Models\RetroNote;
use App\Models\RetroSession;
use App\Models\RetroUser;
use Tests\TestCase;

class RetroNoteTest extends TestCase
{
    public function test_it_can_have_a_retro_note()
    {
        $retroNote = RetroNote::factory()->recycle(RetroSession::factory()->create())->create();

        $this->assertCount(1, $retroNote->retroSession->retroNotes);
    }

    public function test_it_can_have_multiple_retro_notes()
    {
        $retroSession = RetroSession::factory()->create([
            'slug' => 'snickers',
        ]);

        RetroNote::factory(3)->create([
            'retro_session_id' => $retroSession->id,
        ]);

        $this->assertCount(3, $retroSession->retroNotes);
    }
}
