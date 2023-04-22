<?php

namespace Tests\Feature\Models;

use App\Models\Column;
use App\Models\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ColumnTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_column_belongs_to_a_session()
    {
        $session = Session::factory()->create();
        $column = Column::factory()->create(['session_id' => $session->id]);

        $this->assertEquals($session->id, $column->session->id);

        $this->assertInstanceOf(Session::class, $column->session);
    }
}
