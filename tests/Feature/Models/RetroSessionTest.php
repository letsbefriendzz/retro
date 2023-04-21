<?php

namespace Tests\Unit\Models;

use App\Models\RetroNote;
use App\Models\RetroSession;
use App\Models\RetroUser;
use Tests\TestCase;

class RetroSessionTest extends TestCase
{
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

        $this->assertCount(2, $retroSession->fresh()->retroNotes);
        $this->assertTrue($retroSession->retroNotes->contains($retroNote1));
        $this->assertTrue($retroSession->retroNotes->contains($retroNote2));
    }

    public function test_it_has_many_retro_users()
    {
        $retroSession = RetroSession::factory()->create();
        $retroUser1 = RetroUser::factory()->create(['retro_session_id' => $retroSession->id]);
        $retroUser2 = RetroUser::factory()->create(['retro_session_id' => $retroSession->id]);

        $this->assertCount(2, $retroSession->fresh()->retroUsers);
        $this->assertTrue($retroSession->retroUsers->contains($retroUser1));
        $this->assertTrue($retroSession->retroUsers->contains($retroUser2));
    }
}
