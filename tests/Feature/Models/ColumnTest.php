<?php

namespace Tests\Feature\Models;

use App\Models\Column;
use App\Models\Note;
use App\Models\Session;
use Tests\TestCase;

class ColumnTest extends TestCase
{
    public function test_a_column_belongs_to_a_session()
    {
        $session = Session::factory()->create();
        $column = Column::factory()->create(['session_id' => $session->id]);

        $this->assertEquals($session->id, $column->session->id);

        $this->assertInstanceOf(Session::class, $column->session);
    }

    public function test_a_column_has_many_notes()
    {
        $session = Session::factory()->create();
        $column = Column::factory()->create(['session_id' => $session->id]);
        Note::factory(3)->create([
            'column_id' => $column->id,
            'session_id' => $session->id
        ]);

        $this->assertCount(3, $column->notes);
    }
}
