<?php

namespace Tests\Feature\Controllers;

use App\Events\NoteCreated;
use App\Events\NoteDeleted;
use App\Models\Note;
use App\Models\RetroSession;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class NoteControllerTest extends TestCase
{
    private RetroSession $retroSession;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->retroSession = RetroSession::factory()->create();
    }

    public function test_it_can_create_a_retro_note()
    {
        $content = 'snickers snickers snickers snickers';

        $this->post(route('notes.store', [
            'retro_session_id' => $this->retroSession->id,
            'retro_column' => 'wentWell',
            'content' => $content,
        ]))->assertSuccessful();

        $this->assertDatabaseHas('notes', [
            'retro_session_id' => $this->retroSession->id,
            'content' => $content,
        ]);
    }

    public function test_it_can_update_a_retro_note()
    {
        $note = Note::factory()->create([
            'retro_session_id' => $this->retroSession->id,
        ]);

        $this->putJson(route('notes.update', $note), [
            'retro_session_id' => $this->retroSession->id,
            'retro_column' => 'wentWell',
            'content' => 'snickers'
        ])->assertSuccessful();

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'content' => 'snickers',
        ]);
    }

    public function test_it_can_delete_a_retro_note()
    {
        $note = Note::factory()->create([
            'retro_session_id' => $this->retroSession->id,
            'content' => 'snickers',
        ]);

        $this->deleteJson(route('notes.destroy', $note))
            ->assertSuccessful();

        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
            'content' => 'snickers',
        ]);
    }

    public function test_it_dispatches_retro_note_deleted_event()
    {
        Event::fake();

        $note = Note::factory()->create([
            'retro_session_id' => $this->retroSession->id,
            'content' => 'snickers',
        ]);

        $this->deleteJson(route('notes.destroy', $note))
            ->assertSuccessful();

        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
            'content' => 'snickers',
        ]);

        Event::assertDispatched(NoteDeleted::class);
    }

    public function test_it_dispatches_retro_note_created_event()
    {
        Event::fake();

        $content = 'snickers snickers snickers snickers';

        $this->post(route('notes.store', [
            'retro_session_id' => $this->retroSession->id,
            'retro_column' => 'wentWell',
            'content' => $content,
        ]))->assertSuccessful();

        Event::assertDispatched(NoteCreated::class);
    }
}
