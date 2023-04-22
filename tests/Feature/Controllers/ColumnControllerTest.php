<?php

namespace Tests\Feature\Controllers;

use App\Models\Column;
use App\Models\Session;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ColumnControllerTest extends TestCase
{
    private mixed $session;
    private mixed $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->session = Session::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_it_creates_columns()
    {
        $this->post(route('columns.store'), [
            'title' => 'snickers',
            'session_id' => $this->session->id,
        ]);

        $this->assertDatabaseHas('columns', ['title' => 'snickers']);
    }

    public function test_it_deletes_columns()
    {
        $column = Column::factory()->create();

        $this->delete(route('columns.destroy', $column->id));

        $this->assertDatabaseMissing('columns', ['title' => 'snickers']);
    }

    public function test_it_cannot_delete_a_column_that_does_not_exist()
    {
        $this->delete(route('columns.destroy', Column::query()->max('id') + 1))
            ->assertStatus(302); // todo i'd like a status other than 302 when we fail to find a column...
    }
}
