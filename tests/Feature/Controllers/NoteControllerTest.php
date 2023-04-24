<?php

namespace Tests\Feature\Controllers;

use App\Events\NoteCreated;
use App\Events\NoteDeleted;
use App\Models\Column;
use App\Models\Note;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class NoteControllerTest extends TestCase
{
    private Session $session;
    private Column $column;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
        $this->session = Session::factory()->create();
        $this->column = Column::factory()->create(['session_id' => $this->session->id]);
    }

    public function test_it_can_create_a_note()
    {
        $content = 'snickers snickers snickers snickers';

        $this->post(route('notes.store', [
            'session_id' => $this->session->id,
            'column_id' => $this->column->id,
            'content' => $content,
        ]))->assertSuccessful();

        $this->assertDatabaseHas('notes', [
            'session_id' => $this->session->id,
            'column_id' => $this->column->id,
            'content' => $content,
        ]);
    }

    public function test_it_can_update_a_note()
    {
        $note = Note::factory()->create([
            'session_id' => $this->session->id,
            'column_id' => $this->column->id,
        ]);

        $this->putJson(route('notes.update', $note), [
            'session_id' => $this->session->id,
            'column_id' => $this->column->id,
            'content' => 'snickers'
        ])->assertSuccessful();

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'content' => 'snickers',
        ]);
    }

    public function test_it_can_delete_a_note()
    {
        $note = Note::factory()->create([
            'session_id' => $this->session->id,
            'column_id' => $this->column->id,
            'content' => 'snickers',
        ]);

        $this->deleteJson(route('notes.destroy', $note))
            ->assertSuccessful();

        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
            'content' => 'snickers',
        ]);
    }

    public function test_it_dispatches_note_deleted_event()
    {
        Event::fake();

        $note = Note::factory()->create([
            'session_id' => $this->session->id,
            'column_id' => $this->column->id,
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

    public function test_it_dispatches_note_created_event()
    {
        Event::fake();

        $content = 'snickers snickers snickers snickers';

        $this->post(route('notes.store', [
            'session_id' => $this->session->id,
            'column_id' => $this->column->id,
            'content' => $content,
        ]))->assertSuccessful();

        Event::assertDispatched(NoteCreated::class);
    }

    // todo test for authentication
}
