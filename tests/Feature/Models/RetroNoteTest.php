<?php

namespace Tests\Unit\Models;

use App\Models\RetroNote;
use App\Models\RetroSession;
use App\Models\RetroUser;
use Tests\TestCase;

class RetroNoteTest extends TestCase
{
    public function test_it_belongs_to_a_retro_session()
    {
        $retroSession = RetroSession::factory()->create();
        $retroUser = RetroUser::factory()->create(['retro_session_id' => $retroSession->id]);
        $retroNote = RetroNote::factory()->create([
            'retro_user_id' => $retroUser->id,
            'retro_session_id' => $retroSession->id,
        ]);

        $this->assertInstanceOf(RetroSession::class, $retroNote->retroSession);
        $this->assertEquals($retroSession->id, $retroNote->retroSession->id);
    }

    public function test_it_belongs_to_a_retro_user()
    {
        $retroSession = RetroSession::factory()->create();
        $retroUser = RetroUser::factory()->create(['retro_session_id' => $retroSession->id]);
        $retroNote = RetroNote::factory()->create([
            'retro_user_id' => $retroUser->id,
            'retro_session_id' => $retroSession->id,
        ]);

        $this->assertInstanceOf(RetroUser::class, $retroNote->retroUser);
        $this->assertEquals($retroUser->id, $retroNote->retroUser->id);
    }
}
