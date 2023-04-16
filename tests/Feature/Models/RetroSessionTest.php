<?php

namespace Tests\Feature\Models;

use App\Models\RetroNote;
use App\Models\RetroSession;
use App\Models\RetroUser;
use Tests\TestCase;

class RetroSessionTest extends TestCase
{
    public function test_it_can_have_a_retro_note()
    {
        $retroSession = RetroSession::factory()->create([
            'slug' => 'snickers',
        ]);

        RetroNote::factory()->create([
            'retro_session_id' => $retroSession->id,
        ]);

        $this->assertCount(1, $retroSession->retroNotes);
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

    public function test_it_can_have_retro_users()
    {
        $retroSession = RetroSession::factory()->create([
            'slug' => 'snickers',
        ]);

        RetroUser::factory(3)->create([
            'retro_session_id' => $retroSession->id
        ]);

        $this->assertCount(3, $retroSession->retroUsers);
    }
}
