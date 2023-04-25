<?php

namespace Tests\Feature\Controllers;

use App\Events\ColumnCreated;
use App\Events\ColumnDeleted;
use App\Models\Column;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ColumnControllerTest extends TestCase
{
    private Session $session;
    private User $user;

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
        $column = Column::factory()->create(['session_id' => $this->session->id]);

        $this->delete(route('columns.destroy', $column->id));

        $this->assertDatabaseMissing('columns', ['title' => 'snickers']);
    }

    public function test_it_cannot_delete_a_column_that_does_not_exist()
    {
        $this->delete(route('columns.destroy', Column::query()->max('id') + 1))
            ->assertUnprocessable();
    }

    public function test_it_cannot_create_duplicate_column_titles_for_a_session()
    {
        $title = 'snickers';
        $this->session->columns()->create(['title' => $title]);

        $this->post(route('columns.store'), [
            'title' => $title,
            'session_id' => $this->session->id,
        ])
            ->assertUnprocessable()
            ->assertJsonFragment([
                'errors' => [
                    'session_id' => [
                        'A column with the title ' . $title . ' already exists in session #' . $this->session->id . '.'
                    ]
                ],
            ]);
    }

    public function test_it_dispatches_column_created()
    {
        Event::fake();

        $session = Session::factory()->create();

        $this->post(route('columns.store'), [
            'title' => 'snickers',
            'session_id' => $session->id
        ])->assertSuccessful();

        Event::assertDispatched(ColumnCreated::class);
    }

    public function test_it_dispatches_column_deleted()
    {
        Event::fake();

        $session = Session::factory()->create();
        $column = Column::factory()->create(['session_id' => $session->id]);

        $this->delete(route('columns.destroy', [$column->id]), ['session_id' => $session->id])
            ->assertSuccessful();

        Event::assertDispatched(ColumnDeleted::class);
    }
}
