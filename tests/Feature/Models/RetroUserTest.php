<?php

namespace Tests\Unit\Models;

use App\Models\RetroNote;
use App\Models\RetroSession;
use App\Models\RetroUser;
use Tests\TestCase;

class RetroUserTest extends TestCase
{
    public function test_it_belongs_to_a_retro_session()
    {
        $retroSession = RetroSession::factory()->create();
        $retroUser = RetroUser::factory()->create(['retro_session_id' => $retroSession->id]);

        $this->assertInstanceOf(RetroSession::class, $retroUser->retroSession);
        $this->assertEquals($retroSession->id, $retroUser->retroSession->id);
    }

    public function test_it_has_many_retro_notes()
    {
        $retroSession = RetroSession::factory()->create();
        $retroUser = RetroUser::factory()->create(['retro_session_id' => $retroSession->id]);
        $retroNote1 = RetroNote::factory()->create([
            'retro_user_id' => $retroUser->id,
            'retro_session_id' => $retroSession->id,
        ]);
        $retroNote2 = RetroNote::factory()->create([
            'retro_user_id' => $retroUser->id,
            'retro_session_id' => $retroSession->id,
        ]);

        $this->assertCount(2, $retroUser->fresh()->retroNotes);
        $this->assertTrue($retroUser->retroNotes->contains($retroNote1));
        $this->assertTrue($retroUser->retroNotes->contains($retroNote2));
    }
}
