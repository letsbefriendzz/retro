<?php

namespace Tests\Feature\Controllers;

use App\Events\RetroNoteCreated;
use App\Models\RetroNote;
use App\Models\RetroSession;
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

        $this->post(route('retroNotes.store', [
            'retro_session_id' => $this->retroSession->id,
            'retro_column' => 'wentWell',
            'content' => $content,
        ]))->assertSuccessful();

        $this->assertDatabaseHas('retro_notes', [
            'retro_session_id' => $this->retroSession->id,
            'content' => $content,
        ]);
    }

    public function test_it_dispatches_retro_note_created_event_when_note_created()
    {
        $this->withoutExceptionHandling();
        Event::fake();

        $content = 'snickers snickers snickers snickers';

        $this->post(route('retroNotes.store', [
            'retro_session_id' => $this->retroSession->id,
            'retro_column' => 'wentWell',
            'content' => $content,
        ]))->assertSuccessful();

        Event::assertDispatched(RetroNoteCreated::class);
    }

    public function test_it_can_update_a_retro_note()
    {
        $note = RetroNote::factory()->create([
            'retro_session_id' => $this->retroSession->id,
        ]);

        $this->put("/retroNotes/{$this->retroSession->id}", [
            'retro_session_id' => $this->retroSession->id,
            'retro_column' => 'wentWell',
            'content' => 'snickers'
        ])->assertSuccessful();

        $this->assertDatabaseHas('retro_notes', [
            'id' => $note->id,
            'content' => 'snickers',
        ]);
    }

    public function test_it_can_delete_a_retro_note()
    {
        $note = RetroNote::factory()->create([
            'retro_session_id' => $this->retroSession->id,
            'content' => 'snickers',
        ]);

        $this->delete("/retroNotes/{$this->retroSession->id}")->assertSuccessful();

        $this->assertDatabaseMissing('retro_notes', [
            'id' => $note->id,
            'content' => 'snickers',
        ]);
    }
}
