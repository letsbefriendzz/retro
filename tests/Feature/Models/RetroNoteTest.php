<?php

namespace Tests\Feature\Models;

use App\Models\RetroNote;
use App\Models\RetroSession;
use App\Models\RetroUser;
use Tests\TestCase;

class RetroNoteTest extends TestCase
{
    public function test_it_belongs_to_a_retro_session()
    {
        $retroSession = RetroSession::factory()->create();

        $retroUser = RetroUser::factory()->create([
            'retro_session_id' => $retroSession->id,
        ]);

        $retroNote = RetroNote::factory()->create([
            'retro_session_id' => $retroSession->id,
            'retro_user_id' => $retroUser->id,
        ]);

        $this->assertEquals(1, $retroNote->retroSession->count());
    }
}
