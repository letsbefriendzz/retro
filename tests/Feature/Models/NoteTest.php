<?php

namespace Tests\Feature\Models;

use App\Models\Column;
use App\Models\Note;
use App\Models\Session;
use Tests\TestCase;

class NoteTest extends TestCase
{
    public function test_it_belongs_to_a_session()
    {
        $session = Session::factory()->create();
        $column = Column::factory()->create(['session_id' => $session->id]);
        $note = Note::factory()->create([
            'column_id' => $column->id,
            'session_id' => $session->id,
        ]);

        $this->assertInstanceOf(Session::class, $note->session);
        $this->assertEquals($session->id, $note->session->id);
    }
}
