<?php

namespace Tests\Feature\Controllers;

use App\Events\RetroNoteCreated;
use App\Events\RetroNoteDeleted;
use App\Models\RetroNote;
use App\Models\RetroSession;
use App\Models\RetroUser;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RetroNoteControllerTest extends TestCase
{
    private RetroSession $retroSession;

    protected function setUp(): void
    {
        parent::setUp();
        $this->retroSession = RetroSession::factory()->create();
    }

    public function test_it_can_create_a_retro_note()
    {
        $content = 'snickers snickers snickers snickers';

        $user = RetroUser::factory()->create([
            'retro_session_id' => $this->retroSession->id,
        ]);

        $this->post(route('retroNotes.store', [
            'retro_session_id' => $this->retroSession->id,
            'retro_user_id' => $user->id,
            'retro_column' => 'wentWell',
            'content' => $content,
        ]))->assertSuccessful();
//            ->assertJsonStructure(['retroNote' => ['id', 'retro_session_id', 'retro_user_id', 'retro_column', 'content']]);;

        $this->assertDatabaseHas('retro_notes', [
            'retro_session_id' => $this->retroSession->id,
            'retro_user_id' => $user->id,
            'content' => $content,
        ]);
    }

    public function test_it_can_update_a_retro_note()
    {
        $user = RetroUser::factory()->create([
            'retro_session_id' => $this->retroSession->id,
        ]);

        $retroNote = RetroNote::factory()->create([
            'retro_session_id' => $this->retroSession->id,
            'retro_user_id' => $user->id,
        ]);

        $this->putJson(route('retroNotes.update', $retroNote), [
            'retro_session_id' => $this->retroSession->id,
            'retro_user_id' => $user->id,
            'retro_column' => 'wentWell',
            'content' => 'snickers'
        ])->assertSuccessful();

        $this->assertDatabaseHas('retro_notes', [
            'id' => $retroNote->id,
            'content' => 'snickers',
        ]);
    }

    public function test_it_can_delete_a_retro_note()
    {
        $retroUser = RetroUser::factory()->create([
            'retro_session_id' => $this->retroSession->id,
        ]);

        $retroNote = RetroNote::factory()->create([
            'retro_session_id' => $this->retroSession->id,
            'retro_user_id' => $retroUser->id,
            'content' => 'snickers',
        ]);

        $this->deleteJson(route('retroNotes.destroy', $retroNote))
            ->assertSuccessful();

        $this->assertDatabaseMissing('retro_notes', [
            'id' => $retroNote->id,
            'content' => 'snickers',
        ]);
    }

    public function test_it_dispatches_retro_note_deleted_event()
    {
        Event::fake();

        $retroUser = RetroUser::factory()->create([
            'retro_session_id' => $this->retroSession->id,
        ]);

        $retroNote = RetroNote::factory()->create([
            'retro_session_id' => $this->retroSession->id,
            'retro_user_id' => $retroUser->id,
            'content' => 'snickers',
        ]);

        $this->deleteJson(route('retroNotes.destroy', $retroNote))
            ->assertSuccessful();

        $this->assertDatabaseMissing('retro_notes', [
            'id' => $retroNote->id,
            'content' => 'snickers',
        ]);

        Event::assertDispatched(RetroNoteDeleted::class);
    }

    public function test_it_dispatches_retro_note_created_event()
    {
        Event::fake();

        $user = RetroUser::factory()->create([
            'retro_session_id' => $this->retroSession->id,
        ]);

        $content = 'snickers snickers snickers snickers';

        $this->post(route('retroNotes.store', [
            'retro_session_id' => $this->retroSession->id,
            'retro_user_id' => $user->id,
            'retro_column' => 'wentWell',
            'content' => $content,
        ]))->assertSuccessful();

        Event::assertDispatched(RetroNoteCreated::class);
    }
}
