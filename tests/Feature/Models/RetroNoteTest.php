<?php

namespace Tests\Unit\Models;

use App\Models\RetroNote;
use App\Models\RetroSession;
use Tests\TestCase;

class RetroNoteTest extends TestCase
{
    public function test_it_belongs_to_a_retro_session()
    {
        $retroSession = RetroSession::factory()->create();
        $retroNote = RetroNote::factory()->create([
            'retro_session_id' => $retroSession->id,
        ]);

        $this->assertInstanceOf(RetroSession::class, $retroNote->retroSession);
        $this->assertEquals($retroSession->id, $retroNote->retroSession->id);
    }
}
