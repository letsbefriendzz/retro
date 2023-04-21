<?php

namespace Tests\Unit\Models;

use App\Models\RetroNote;
use App\Models\RetroSession;
use Tests\TestCase;

class RetroSessionTest extends TestCase
{
    public function test_it_has_many_retro_notes()
    {
        $retroSession = RetroSession::factory()->create();
        $retroNote1 = RetroNote::factory()->create([
            'retro_session_id' => $retroSession->id,
        ]);
        $retroNote2 = RetroNote::factory()->create([
            'retro_session_id' => $retroSession->id,
        ]);

        $this->assertCount(2, $retroSession->fresh()->retroNotes);
        $this->assertTrue($retroSession->retroNotes->contains($retroNote1));
        $this->assertTrue($retroSession->retroNotes->contains($retroNote2));
    }
}
