<?php

namespace Tests\Feature\Models;

use App\Models\Column;
use App\Models\Note;
use App\Models\Session;
use Tests\TestCase;

class SessionTest extends TestCase
{
    public function test_it_has_many_notes()
    {
        $session = Session::factory()->create();
        $column = Column::factory()->create(['session_id' => $session->id]);
        $note1 = Note::factory()->create([
            'column_id' => $column->id,
            'session_id' => $session->id,
        ]);
        $note2 = Note::factory()->create([
            'column_id' => $column->id,
            'session_id' => $session->id,
        ]);

        $this->assertCount(2, $session->fresh()->notes);
        $this->assertTrue($session->notes->contains($note1));
        $this->assertTrue($session->notes->contains($note2));
    }

    public function test_it_creates_default_columns()
    {
        $session = Session::factory()->create(['slug' => 'snickers']);

        $this->assertDatabaseCount('columns', 0);

        $session->createDefaultColumns();

        $this->assertDatabaseCount('columns', 3);
        $this->assertCount(3, $session->columns);
    }
}
